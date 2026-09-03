document.addEventListener('DOMContentLoaded', function () {

    // Independent of everything else in this file on purpose — see the
    // carousel button bug from earlier for why nesting this inside logic
    // that can `return` early elsewhere would be a mistake. This runs a
    // find-and-replace on visible text only (never on script/style tags
    // or on link URLs/attributes), swapping any Philippine Peso symbol
    // for the correct Indian Rupee one. It's a client-side patch over
    // whatever is producing the wrong character server-side; the code
    // fix for that still stands and should be sorted out on the server
    // when possible, but this makes the storefront correct in the
    // meantime regardless of that.

    const wrongSymbols = ['\u20B1']; // ₱ Philippine Peso

    const walker = document.createTreeWalker(
        document.body,
        NodeFilter.SHOW_TEXT,
        {
            acceptNode: function (node) {
                const tag = node.parentNode && node.parentNode.nodeName;
                if (tag === 'SCRIPT' || tag === 'STYLE') {
                    return NodeFilter.FILTER_REJECT;
                }
                return NodeFilter.FILTER_ACCEPT;
            }
        }
    );

    let n;
    while ((n = walker.nextNode())) {
        wrongSymbols.forEach(function (symbol) {
            if (n.nodeValue.indexOf(symbol) !== -1) {
                n.nodeValue = n.nodeValue.split(symbol).join('\u20B9'); // ₹
            }
        });
    }

});

document.addEventListener('DOMContentLoaded', function () {

    // Independent listener, same reasoning as above: never nest cart
    // logic inside code elsewhere in this file that might `return` early.
    //
    // The PHP-side fix (woocommerce_add_to_cart_fragments) keeps the nav
    // and bottom-bar cart-count badges in sync for the classic AJAX
    // add-to-cart flow — both fire the jQuery events this also listens
    // for below, as a second safety net.
    //
    // But this storefront mixes classic WooCommerce with WooCommerce
    // Blocks in several places (the shop grid's Add to Cart buttons and
    // the /cart/ page are both block-based, going by their markup), and
    // Blocks talks to the Store API directly rather than reliably firing
    // those classic jQuery events. So this also re-checks the real cart
    // count straight from the Store API itself after any click that
    // looks cart-related, ANYWHERE on the page — not just inside the
    // cart page — since the earlier version only listened inside the
    // /cart/ page's own block and missed every Add to Cart click
    // elsewhere on the site.

    function setCartBadges(count) {
        document.querySelectorAll('.nav-cart-count, .bottom-cart-count').forEach(function (el) {
            el.textContent = count;
        });
    }

    function refreshCartCountFromServer() {
        // cache: 'no-store' plus a cache-busting query param — belt and
        // braces against this host's history of caching things more
        // aggressively than expected, including possibly this endpoint.
        fetch('/wp-json/wc/store/v1/cart?_=' + Date.now(), {
            credentials: 'same-origin',
            cache: 'no-store',
            headers: { 'Cache-Control': 'no-cache' }
        })
            .then(function (response) { return response.ok ? response.json() : null; })
            .then(function (data) {
                if (!data) {
                    return;
                }
                // Prefer items_count (total quantity across all items —
                // what "5 different items" should add up to), but fall
                // back to summing the items array directly in case a
                // WooCommerce version/response shape doesn't include it.
                var count = data.items_count;
                if (typeof count === 'undefined' && Array.isArray(data.items)) {
                    count = data.items.reduce(function (sum, item) {
                        return sum + (item.quantity || 0);
                    }, 0);
                }
                if (typeof count !== 'undefined') {
                    setCartBadges(count);
                }
            })
            .catch(function () {
                // Store API unavailable for some reason — badges just keep
                // showing their last known value rather than erroring out.
            });
    }

    if (window.jQuery) {
        window.jQuery(document.body).on('added_to_cart removed_from_cart wc_fragment_refresh updated_wc_div', refreshCartCountFromServer);
    }

    // Delegated, document-wide, capture phase — catches every cart-related
    // click regardless of which part of the site it happens on or whether
    // something else on the page later calls stopPropagation().
    document.addEventListener('click', function (e) {
        const target = e.target.closest('button, a, input[type="number"], [role="button"]');
        if (!target) {
            return;
        }
        const cartRelated = target.closest(
            '[class*="cart" i], [class*="add-to-cart" i], [class*="wc-block" i], .woocommerce, [data-block-name*="woocommerce" i]'
        );
        if (!cartRelated) {
            return;
        }
        // No single reliable "done" event from a block's internal Store
        // API call, so re-check a few times shortly after any click that
        // could be an add/remove/quantity change — cheap and harmless if
        // the click turns out not to have changed the cart.
        window.setTimeout(refreshCartCountFromServer, 600);
        window.setTimeout(refreshCartCountFromServer, 1500);
        window.setTimeout(refreshCartCountFromServer, 3000);
    }, true);


});

document.addEventListener('DOMContentLoaded', function () {

    const storageKey = 'ssi-fanzine-theme-mode';

    const header = document.querySelector('.site-header');
    if (!header) {
        console.warn('SSI Fanzine: .site-header not found');
        return;
    }

    const buttons = document.querySelectorAll('.mobile-menu-button, .bottom-menu-toggle');
    const menu = document.querySelector('.mobile-navigation');

    
    let lastScrollY = window.scrollY;
    let ticking = false;

    const handleScroll = function () {
        const currentScrollY = window.scrollY;
        const delta = currentScrollY - lastScrollY;

        // Always show the header at the very top.
        if (currentScrollY <= 60) {
            header.classList.remove('is-hidden');
            lastScrollY = currentScrollY;
            return;
        }

        // Keep the header visible while the mobile menu is open.
        if (menu && menu.classList.contains('is-open')) {
            header.classList.remove('is-hidden');
            lastScrollY = currentScrollY;
            return;
        }

        // Ignore tiny movements to avoid flicker.
        if (Math.abs(delta) < 4) {
            return;
        }

        if (delta > 0) {
            // Scrolling down: hide the existing header.
            header.classList.add('is-hidden');
        } else {
            // Scrolling up: restore the existing header.
            header.classList.remove('is-hidden');
        }

        lastScrollY = currentScrollY;
    };

    window.addEventListener('scroll', function () {
        if (!ticking) {
            window.requestAnimationFrame(function () {
                handleScroll();
                ticking = false;
            });
            ticking = true;
        }
    }, { passive: true });

    const themeToggle = document.querySelector('.theme-toggle');
    const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedMode = localStorage.getItem(storageKey);

    const setThemeMode = function (mode) {

        document.documentElement.dataset.theme = mode;

        if (!themeToggle) {
            return;
        }

        const isDark = mode === 'dark';

        themeToggle.setAttribute('aria-pressed', isDark ? 'true' : 'false');
        themeToggle.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');

    };

    // Light by default, but keep the user's chosen mode across visits.
    setThemeMode(savedMode || 'light');

    if (themeToggle) {

        themeToggle.addEventListener('click', function () {

            const currentMode = document.documentElement.dataset.theme === 'dark' ? 'dark' : 'light';
            const nextMode = currentMode === 'dark' ? 'light' : 'dark';

            localStorage.setItem(storageKey, nextMode);
            setThemeMode(nextMode);

        });

    }
if (!buttons.length || !menu) {
        // Menu elements not found, but scroll handler still runs
    }

    const setMenuState = function (isOpen) {

        menu.classList.toggle('is-open', isOpen);
        document.body.classList.toggle('mobile-menu-open', isOpen);

        // Always show the header while its menu is open.
        if (isOpen) {
            header.classList.remove('is-hidden');
        }

        buttons.forEach(function (button) {

            button.setAttribute(
                'aria-expanded',
                isOpen ? 'true' : 'false'
            );

            button.setAttribute(
                'aria-label',
                isOpen ? 'Close menu' : 'Open menu'
            );

        });

    };

    buttons.forEach(function (button) {

        button.addEventListener('click', function () {

            setMenuState(!menu.classList.contains('is-open'));

        });

    });

    menu.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            setMenuState(false);
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && menu.classList.contains('is-open')) {
            setMenuState(false);
        }
    });

    // The hero slider and the editorial/magazine carousels are independent
    // features. Previously this code returned early when .featured-slider
    // was missing/empty, which also skipped the carousel button wiring
    // below — breaking every next/prev button on the page whenever the
    // hero slider wasn't present. Each block now only skips itself.

    const slider = document.querySelector('.featured-slider');

    if (slider) {

        const track = slider.querySelector('.featured-track');
        const slides = slider.querySelectorAll('.featured-story');
        const dots = slider.querySelectorAll('.featured-dot');
        const len = slides.length;

        if (track && len) {

            let index = 0;
            let timer = null;

            const goTo = function (i) {

                index = (i + len) % len;
                track.style.transform = 'translateX(-' + index * 100 + '%)';

                dots.forEach(function (dot, di) {
                    const active = di === index;
                    dot.classList.toggle('is-active', active);
                    dot.setAttribute('aria-pressed', active ? 'true' : 'false');
                });

            };

            const start = function () {
                timer = window.setInterval(function () { goTo(index + 1); }, 5000);
            };

            const stop = function () {
                if (timer) {
                    window.clearInterval(timer);
                    timer = null;
                }
            };

            dots.forEach(function (dot, di) {
                dot.addEventListener('click', function () { stop(); goTo(di); start(); });
            });

            slider.addEventListener('mouseenter', stop);
            slider.addEventListener('mouseleave', function () { start(); });

            let touchStartX = 0;
            slider.addEventListener('touchstart', function (e) {
                touchStartX = e.touches[0].clientX;
                stop();
            }, { passive: true });

            slider.addEventListener('touchend', function (e) {
                const dx = e.changedTouches[0].clientX - touchStartX;
                goTo(index + (dx < -40 ? 1 : dx > 40 ? -1 : 0));
                start();
            }, { passive: true });

            goTo(0);
            start();

        }

    }

    document.querySelectorAll('.editorial-carousel').forEach(function (carousel) {

        // The prev/next buttons live in .section-title (next to the
        // heading), which is a sibling of .editorial-carousel, not a
        // descendant of it — so searching only inside `carousel` always
        // came back empty and silently skipped every carousel on the
        // site. Search the shared parent instead.
        const scope = carousel.parentElement || carousel;

        const grid = carousel.querySelector('.editorial-grid');
        const prev = scope.querySelector('.editorial-prev');
        const next = scope.querySelector('.editorial-next');

        if (!grid || !prev || !next) {
            return;
        }

        const step = function () {
            const card = grid.firstElementChild;
            return card ? card.getBoundingClientRect().width + parseFloat(getComputedStyle(grid).columnGap || getComputedStyle(grid).gap || 20) || 20 : 0;
        };

        const update = function () {
            prev.disabled = grid.scrollLeft <= 4;
            next.disabled = grid.scrollLeft >= (grid.scrollWidth - grid.clientWidth - 4);
        };

        prev.addEventListener('click', function () { grid.scrollBy({ left: -step(), behavior: 'smooth' }); });
        next.addEventListener('click', function () { grid.scrollBy({ left: step(), behavior: 'smooth' }); });
        grid.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
        update();

    });

});

