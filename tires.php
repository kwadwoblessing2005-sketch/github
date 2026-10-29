<?php
declare(strict_types=1);

require __DIR__ . '/auth.php';

if (!isSignedIn()) {
    header('Location: index.php');
    exit;
}

$products = [
    [
        'size' => '175/65R13',
        'type' => 'All Season Tire',
        'description' => 'Fuel-efficient, Wet grip, Comfort ride',
        'tag' => 'CITY FAVOURITE',
    ],
    [
        'size' => '175/70R13',
        'type' => 'All Season Tire',
        'description' => 'Reliable grip, Long tread life',
        'tag' => 'GREAT VALUE',
    ],
    [
        'size' => '185/65R14',
        'type' => 'All Season Tire',
        'description' => 'Stable handling, Quiet drive',
        'tag' => 'SMOOTH RIDE',
    ],
    [
        'size' => '185/70R14',
        'type' => 'All Season Tire',
        'description' => 'Heavy load, Durable',
        'tag' => 'DURABLE PICK',
    ],
    [
        'size' => '185/65R15',
        'type' => 'All Season Tire',
        'description' => 'Enhanced traction, Balanced performance',
        'tag' => 'ALL-ROUNDER',
    ],
    [
        'size' => '195/65R15',
        'type' => 'All Season Tire',
        'description' => 'Improved stability, All weather',
        'tag' => 'ROAD READY',
    ],
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#111111">
    <meta name="description" content="Shop quality, affordable all-season car tires from Mathew Agyei Henry Tires Ghana. Kumasi delivery and nationwide shipping.">
    <title>Mathew Agyei Henry Tires Ghana | Quality tires</title>
    <link rel="stylesheet" href="styles.css">
    <script src="shop.js" defer></script>
</head>
<body class="shop-page">
    <div class="announcement">
        <span>FREE DELIVERY IN KUMASI ON ORDERS OVER <strong>GH₵ 1,000</strong></span>
        <span class="announcement-contact">Call us: <a href="tel:+233244603485">0244603485</a><span aria-hidden="true">•</span> Mon-Sat 8am-6pm</span>
    </div>

    <header class="shop-header">
        <a class="brand" href="#home" aria-label="Mathew Agyei Henry Tires Ghana home">
            <span class="brand-mark" aria-hidden="true">
                <svg viewBox="0 0 48 48" role="img">
                    <circle cx="24" cy="24" r="19" fill="none" stroke="currentColor" stroke-width="7"/>
                    <circle cx="24" cy="24" r="9" fill="none" stroke="currentColor" stroke-width="4"/>
                    <path d="M24 5v5m0 28v5M5 24h5m28 0h5M10.6 10.6l3.6 3.6m19.6 19.6 3.6 3.6m0-26.8-3.6 3.6m-19.6 19.6-3.6 3.6" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                </svg>
            </span>
            <span class="brand-copy"><strong>MATHEW AGYEI HENRY</strong><small>TIRES GHANA</small></span>
        </a>

        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="main-navigation">
            <span></span><span></span><span></span>
            <span class="visually-hidden">Toggle navigation</span>
        </button>

        <nav class="main-navigation" id="main-navigation" aria-label="Main navigation">
            <a href="#home">Home</a>
            <a href="#products">Products</a>
            <a href="#offers">Offers</a>
            <a href="#about">About Us</a>
            <a href="#contact">Contact</a>
        </nav>

        <div class="header-actions">
            <button class="cart-button" type="button" data-open-cart aria-label="Open shopping cart">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2.1 10.1a2 2 0 0 0 2 1.6h8.7a2 2 0 0 0 2-1.6L21 8H6M10 20a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/></svg>
                <span>Cart</span><span class="cart-count" data-cart-count>0</span>
            </button>
            <form class="shop-signout" method="post" action="logout.php">
                <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token']) ?>">
                <button type="submit">Sign out</button>
            </form>
        </div>
    </header>

    <main>
        <section class="hero" id="home">
            <div class="hero-copy">
                <p class="hero-kicker"><span></span> YOUR JOURNEY STARTS HERE</p>
                <h1>Quality Tires<br>for <span>Ghana Roads.</span></h1>
                <p class="hero-description">Durable. Affordable. Reliable tires for all vehicles. Shop top sizes with fast nationwide delivery.</p>
                <div class="hero-actions">
                    <a class="button button-yellow" href="#products">Shop tires <span aria-hidden="true">↗</span></a>
                    <a class="hero-call" href="tel:+233244603485"><span class="call-icon" aria-hidden="true">☎</span><span><small>NEED HELP?</small><strong>024 460 3485</strong></span></a>
                </div>
                <div class="hero-benefits">
                    <span><b aria-hidden="true">✓</b> Quality checked</span>
                    <span><b aria-hidden="true">✓</b> Fast delivery</span>
                    <span><b aria-hidden="true">✓</b> Secure checkout</span>
                </div>
            </div>
            <div class="hero-art" aria-hidden="true">
                <div class="hero-circle"></div>
                <img src="tire.svg" alt="">
                <span class="hero-sticker"><strong>100%</strong><small>ROAD<br>READY</small></span>
                <span class="hero-spark hero-spark-one">✳</span>
                <span class="hero-spark hero-spark-two">✦</span>
            </div>
            <a class="hero-scroll" href="#products"><span></span> SCROLL TO EXPLORE</a>
        </section>

        <section class="benefit-strip" aria-label="Shopping benefits">
            <div><span class="benefit-icon" aria-hidden="true">↗</span><p><strong>Fast nationwide delivery</strong><small>From Kumasi to your doorstep</small></p></div>
            <div><span class="benefit-icon" aria-hidden="true">◇</span><p><strong>Quality you can trust</strong><small>Ready for Ghana's roads</small></p></div>
            <div><span class="benefit-icon" aria-hidden="true">₵</span><p><strong>Prices you'll love</strong><small>Great tires, fair prices</small></p></div>
        </section>

        <section class="products-section" id="products">
            <div class="section-heading">
                <div>
                    <p class="section-kicker">FIND YOUR PERFECT FIT</p>
                    <h2>Popular tire sizes<span>.</span></h2>
                    <p class="section-description">The right fit for everyday drives and long-distance journeys.</p>
                </div>
                <a class="text-link" href="https://wa.me/233244603485?text=Hello%2C%20I%20need%20help%20finding%20a%20tire%20size." target="_blank" rel="noopener noreferrer">Need help choosing? <span aria-hidden="true">↗</span></a>
            </div>

            <div class="product-grid">
                <?php foreach ($products as $index => $product): ?>
                    <article class="product-card" data-product-id="<?= $index ?>">
                        <div class="product-image">
                            <span class="product-tag"><?= e($product['tag']) ?></span>
                            <img src="tire.svg" alt="All-season car tire, tread and wheel" loading="lazy">
                            <span class="image-size"><?= e($product['size']) ?></span>
                        </div>
                        <div class="product-info">
                            <p class="product-type"><?= e($product['type']) ?></p>
                            <h3><?= e($product['size']) ?></h3>
                            <p class="product-description"><?= e($product['description']) ?></p>
                            <div class="product-bottom">
                                <p class="product-price">GH₵ 300 <small>/ piece</small></p>
                                <button class="add-button" type="button"
                                        data-add-to-cart
                                        data-name="<?= e($product['size'] . ' - ' . $product['type']) ?>"
                                        data-price="300"
                                        aria-label="Add <?= e($product['size']) ?> tire to cart">
                                    <span aria-hidden="true">+</span> Add to Cart
                                </button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="offer-banner" id="offers">
            <div class="offer-icon" aria-hidden="true">%</div>
            <div><p class="section-kicker">A LITTLE EXTRA FOR THE ROAD</p><h2>Spend GH₵ 1,000+ and delivery in Kumasi is on us.</h2></div>
            <a class="button button-dark" href="#products">Shop the collection <span aria-hidden="true">↗</span></a>
        </section>

        <section class="about-section" id="about">
            <span class="about-mark" aria-hidden="true">MAH</span>
            <div><p class="section-kicker">LOCAL SERVICE. REAL VALUE.</p><h2>Here for every road ahead.</h2><p>Mathew Agyei Henry Tires Ghana brings durable, affordable tire options to drivers in Kumasi and across Ghana. Need help finding your size? Give us a call or send a WhatsApp message.</p></div>
            <a class="button button-outline" href="https://wa.me/233244603485?text=Hello%2C%20Mathew%20Agyei%20Henry%20Tires%20Ghana." target="_blank" rel="noopener noreferrer">Talk to our team <span aria-hidden="true">↗</span></a>
        </section>
    </main>

    <footer class="shop-footer" id="contact">
        <div class="footer-main">
            <div class="footer-brand">
                <a class="brand brand-footer" href="#home">
                    <span class="brand-mark" aria-hidden="true">
                        <svg viewBox="0 0 48 48"><circle cx="24" cy="24" r="19" fill="none" stroke="currentColor" stroke-width="7"/><circle cx="24" cy="24" r="9" fill="none" stroke="currentColor" stroke-width="4"/><path d="M24 5v5m0 28v5M5 24h5m28 0h5M10.6 10.6l3.6 3.6m19.6 19.6 3.6 3.6m0-26.8-3.6 3.6m-19.6 19.6-3.6 3.6" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                    </span>
                    <span class="brand-copy"><strong>MATHEW AGYEI HENRY</strong><small>TIRES GHANA</small></span>
                </a>
                <p>Quality tires. Reliable journeys.<br>We're here to keep Ghana moving.</p>
            </div>
            <div class="footer-column"><h3>Explore</h3><a href="#home">Home</a><a href="#products">Products</a><a href="#offers">Offers</a><a href="#about">About us</a></div>
            <div class="footer-column"><h3>Visit or call</h3><p>Kumasi, Ghana</p><a href="tel:+233244603485">024 460 3485</a><p>Mon-Sat, 8am-6pm</p></div>
            <div class="footer-column"><h3>Payment options</h3><p>MTN MoMo</p><p>Visa</p><p>Cash on Delivery</p></div>
        </div>
        <div class="footer-bottom"><span>© <?= date('Y') ?> Mathew Agyei Henry Tires Ghana</span><span>Made for the roads we share.</span></div>
    </footer>

    <a class="whatsapp-float" href="https://wa.me/233244603485?text=Hello%2C%20I%27m%20interested%20in%20your%20tires." target="_blank" rel="noopener noreferrer" aria-label="Chat with us on WhatsApp">
        <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M16.05 3A12.9 12.9 0 0 0 4.94 22.46L3.2 28.8l6.49-1.7A12.9 12.9 0 1 0 16.05 3Zm0 23.45a10.5 10.5 0 0 1-5.35-1.47l-.38-.23-3.85 1.01 1.03-3.75-.25-.39a10.53 10.53 0 1 1 8.8 4.83Zm5.78-7.89c-.32-.16-1.9-.94-2.2-1.05-.3-.1-.51-.16-.73.16-.21.32-.83 1.05-1.02 1.27-.19.21-.38.24-.7.08-.33-.16-1.37-.51-2.61-1.62-.97-.86-1.62-1.92-1.81-2.24-.19-.32-.02-.49.14-.65.14-.14.32-.38.49-.57.16-.19.21-.33.32-.54.1-.21.05-.4-.03-.57-.08-.16-.73-1.76-1-2.4-.27-.62-.53-.54-.73-.55h-.62c-.21 0-.57.08-.86.4-.3.32-1.14 1.11-1.14 2.7s1.17 3.13 1.33 3.35c.16.21 2.3 3.51 5.58 4.93.78.34 1.39.55 1.87.7.79.25 1.51.21 2.08.13.63-.1 1.9-.78 2.17-1.54.27-.76.27-1.41.19-1.54-.08-.14-.3-.22-.62-.38Z"/></svg>
        <span>WhatsApp us</span>
    </a>

    <div class="cart-backdrop" data-cart-backdrop hidden></div>
    <aside class="cart-drawer" data-cart-drawer aria-label="Shopping cart" aria-hidden="true" inert>
        <div class="cart-drawer-header"><div><p class="section-kicker">YOUR SELECTION</p><h2>Your cart <span data-drawer-count>(0)</span></h2></div><button class="cart-close" type="button" data-close-cart aria-label="Close cart">×</button></div>
        <div class="cart-items" data-cart-items><p class="empty-cart">Your cart is waiting for the right tires.</p></div>
        <div class="cart-drawer-footer"><div class="cart-total"><span>Total</span><strong data-cart-total>GH₵ 0</strong></div><button class="checkout-button" type="button" data-checkout disabled>Order on WhatsApp <span aria-hidden="true">↗</span></button><p class="cart-note">Delivery details can be confirmed with our team.</p></div>
    </aside>
</body>
</html>
