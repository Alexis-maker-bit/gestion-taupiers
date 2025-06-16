<?php
/**
* Template pour l'archive des taupiers avec filtre par département (slider)
*/
get_header();

$current_page = get_query_var('paged') ? get_query_var('paged') : 1;
$meta_description = '';

if (is_tax('taupier_category')) {
    $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
    $meta_description = "Liste des taupiers professionnels dans la catégorie " . $current_term->name . ".";
} elseif (is_tax('taupier_tag')) {
    $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
    $meta_description = "Taupiers spécialisés avec l'expertise " . $current_term->name . ".";
} else {
    $meta_description = "Annuaire complet des taupiers professionnels.";
}
?>

<div id="primary" class="content-area taupier-archive-container">
    <main id="main" class="site-main" role="main">
        <?php 
        // Ajout du fil d'Ariane
        if (function_exists('display_taupier_breadcrumbs')) {
            // Note : Cette fonction doit maintenant être appelée via l'instance de la classe du plugin
            global $gestion_taupiers;
            if (isset($gestion_taupiers) && method_exists($gestion_taupiers, 'display_taupier_breadcrumbs')) {
                $gestion_taupiers->display_taupier_breadcrumbs();
            }
        }
        ?>
        <header class="page-header">
            <h1 class="page-title">
                <?php
                if (is_tax('taupier_category')) {
                    echo 'Taupiers professionnels : ' . single_term_title('', false);
                } elseif (is_tax('taupier_tag')) {
                    echo 'Experts taupiers : ' . single_term_title('', false);
                } else {
                    echo 'Annuaire des taupiers professionnels';
                }
                ?>
            </h1>

            <p class="departement-intro">Choisissez votre département pour trouver un taupier proche de chez vous</p>

            <div class="departement-slider">
                <?php
                $departements = array(
                    '01' => 'taupier-ain', '02' => 'taupier-aisne', '03' => 'taupier-allier',
                    '04' => 'taupier-alpes-haute-provence', '05' => 'taupier-hautes-alpes', '06' => 'taupier-alpes-maritimes',
                    '07' => 'taupier-ardeche', '08' => 'taupier-ardennes', '09' => 'taupier-ariege',
                    '10' => 'taupier-troyes', '11' => 'taupier-aude', '12' => 'taupier-aveyron',
                    '13' => 'taupier-bouches-du-rhone', '14' => 'taupier-calvados', '15' => 'taupier-cantal',
                    '16' => 'taupier-charente', '17' => 'taupier-charente-maritime', '18' => 'taupier-cher',
                    '19' => 'taupier-correze', '2A' => 'taupier-corse-du-sud', '2B' => 'taupier-haute-corse',
                    '21' => 'taupier-cote-dor', '22' => 'taupier-cotes-darmor', '23' => 'taupier-creuse',
                    '24' => 'taupier-dordogne', '25' => 'taupier-doubs', '26' => 'taupier-drome',
                    '27' => 'taupier-eure', '28' => 'taupier-eure-et-loir', '29' => 'taupier-finistere',
                    '30' => 'taupier-gard', '31' => 'taupier-haute-garonne', '32' => 'taupier-gers',
                    '33' => 'taupier-gironde', '34' => 'taupier-herault', '35' => 'taupier-ille-et-vilaine',
                    '36' => 'taupier-indre', '37' => 'taupier-indre-et-loire', '38' => 'taupier-isere',
                    '39' => 'taupier-jura', '40' => 'taupier-landes', '41' => 'taupier-loir-et-cher',
                    '42' => 'taupier-la-loire', '43' => 'taupier-haute-loire', '44' => 'taupier-loire-atlantique',
                    '45' => 'taupier-loiret', '46' => 'taupier-lot', '47' => 'taupier-lot-et-garonne',
                    '48' => 'taupier-lozere', '49' => 'taupier-maine-et-loire', '50' => 'taupier-la-manche',
                    '51' => 'taupier-marne', '52' => 'taupier-haute-marne', '53' => 'taupier-mayenne',
                    '54' => 'taupier-meurthe-et-moselle', '55' => 'taupier-meuse', '56' => 'taupier-morbihan',
                    '57' => 'taupier-moselle', '58' => 'taupier-nievre', '59' => 'taupier-le-nord',
                    '60' => 'taupier-oise', '61' => 'taupier-orne', '62' => 'taupier-pas-de-calais',
                    '63' => 'taupier-puy-de-dome', '64' => 'taupier-pyrenees-atlantiques', '65' => 'taupier-hautes-pyrenees',
                    '66' => 'taupier-pyrenees-orientales', '67' => 'taupier-bas-rhin', '68' => 'taupier-haut-rhin',
                    '69' => 'taupier-rhone', '70' => 'taupier-haute-saone', '71' => 'taupier-saone-et-loire',
                    '72' => 'taupier-sarthe', '73' => 'taupier-savoie', '74' => 'taupier-haute-savoie',
                    '75' => 'taupier-paris', '76' => 'taupier-seine-maritime', '77' => 'taupier-seine-et-marne',
                    '78' => 'taupier-yvelines', '79' => 'taupier-deux-sevres', '80' => 'taupier-somme',
                    '81' => 'taupier-tarn', '82' => 'taupier-tarn-et-garonne', '83' => 'taupier-provence-alpes-cote-azur',
                    '84' => 'taupier-vaucluse', '85' => 'taupier-vendee', '86' => 'taupier-vienne',
                    '87' => 'taupier-haute-vienne', '88' => 'taupier-les-vosges', '89' => 'taupier-yonne',
                    '90' => 'taupier-territoire-de-belfort', '91' => 'taupier-essonne', '92' => 'taupier-hauts-de-seine',
                    '93' => 'taupier-seine-saint-denis', '94' => 'taupier-val-de-marne', '95' => 'taupier-val-d-oise'
                );
                $current_term_slug = is_tax('taupier_category') ? get_queried_object()->slug : '';
                
                // ### DÉBUT DE LA CORRECTION ###
                foreach ($departements as $num => $slug) {
                    $link = get_term_link($slug, 'taupier_category');

                    // On vérifie si le lien est valide avant de l'afficher.
                    // Si la catégorie n'existe pas, la condition sera fausse et le lien ne sera pas affiché.
                    if (!is_wp_error($link)) {
                        $active_class = ($slug === $current_term_slug) ? ' active' : '';
                        echo '<a class="dep-btn' . $active_class . '" href="' . esc_url($link) . '">' . $num . '</a>';
                    }
                }
                // ### FIN DE LA CORRECTION ###
                ?>
            </div>
        </header>

        <div class="shop-promo-banner">
            <p>Si vous voulez acheter votre propre matériel de piégeage, rendez-vous ici :</p>
            <a href="https://quicktaupe.fr/boutique/" class="promo-button">
                Accéder à la boutique 🛒
            </a>
        </div>
        <?php if (have_posts()) : ?>
        <div class="taupier-list">
            <?php while (have_posts()) : the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="taupier-card-link" aria-label="Voir le profil de <?php echo esc_attr(get_the_title()); ?>">
                <article class="taupier-card" itemscope itemtype="https://schema.org/LocalBusiness">
                    <div class="taupier-card-inner">
                        <div class="taupier-media">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', array('itemprop' => 'image', 'loading' => 'lazy', 'alt' => 'Photo de ' . get_the_title())); ?>
                            <?php else: ?>
                                <div class="taupier-thumbnail-placeholder"><div class="placeholder-icon">👤</div></div>
                            <?php endif; ?>

                            <?php
                            $reviews = get_posts(array(
                                'post_type' => 'taupier_review',
                                'posts_per_page' => -1,
                                'meta_query' => array(
                                    array('key' => '_taupier_review_taupier_id', 'value' => get_the_ID(), 'compare' => '='),
                                    array('key' => '_taupier_review_status', 'value' => 'approved', 'compare' => '=')
                                )
                            ));
                            $average_rating = 0;
                            $count_reviews = count($reviews);
                            if ($count_reviews > 0) {
                                $total_rating = array_sum(array_map(function($r) {
                                    return intval(get_post_meta($r->ID, '_taupier_review_rating', true));
                                }, $reviews));
                                $average_rating = round($total_rating / $count_reviews, 1);
                            }
                            ?>
                            <?php if ($average_rating > 0) : ?>
                            <div class="taupier-rating" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
                                <div class="stars-container">
                                    <?php
                                    $full_stars = floor($average_rating);
                                    $half_star = $average_rating - $full_stars >= 0.5;
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $full_stars) echo '<span class="star full">★</span>';
                                        elseif ($i == $full_stars + 1 && $half_star) echo '<span class="star half">★</span>';
                                        else echo '<span class="star empty">☆</span>';
                                    }
                                    ?>
                                </div>
                                <div class="rating-text">
                                    <span class="rating-value" itemprop="ratingValue"><?php echo $average_rating; ?></span>/5
                                    <meta itemprop="bestRating" content="5">
                                    <span class="reviews-count">(<span itemprop="reviewCount"><?php echo $count_reviews; ?></span> avis)</span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="taupier-content">
                            <h2 class="taupier-title" itemprop="name"><?php the_title(); ?></h2>

                            <div class="taupier-meta">
                                <?php $zone = get_post_meta(get_the_ID(), '_taupier_zone', true);
                                if (!empty($zone)) : ?>
                                    <div class="meta-item zone" itemprop="serviceArea">📍 <span><?php echo esc_html($zone); ?></span></div>
                                <?php endif; ?>

                                <?php $experience = get_post_meta(get_the_ID(), '_taupier_experience', true);
                                if (!empty($experience)) : ?>
                                    <div class="meta-item experience">⏳ <span><?php echo esc_html($experience); ?> ans</span></div>
                                <?php endif; ?>
                            </div>

                            <div class="taupier-excerpt" itemprop="description">
                                <?php echo mb_strimwidth(strip_tags(get_the_excerpt()), 0, 150, '…'); ?>
                            </div>

                            <div class="taupier-actions">
                                <span class="btn btn-primary">Voir le profil</span>
                                <?php $phone = get_post_meta(get_the_ID(), '_taupier_phone', true);
                                if (!empty($phone)) : ?>
                                    <span class="btn btn-secondary">📞 Contacter</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </article>
            </a>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>

        <?php
        // Affichage de la description de la taxonomie SOUS la liste des taupiers
        $term_description = term_description();
        if (!empty($term_description)) {
            echo '<div class="archive-description-after-list">' . $term_description . '</div>';
        }
        ?>

    </main>
</div>

<style>
/* Styles CSS, inchangés */
:root {
    --primary-color: #207648;
    --secondary-color: #6B381F;
    --accent-color: #FFD700;
    --light-bg: #F8F8F8;
    --dark-text: #333333;
    --medium-text: #555555;
    --light-text: #FFFFFF;
    --border-color: #E0E0E0;
    --shadow-light: rgba(0, 0, 0, 0.08);
    --shadow-medium: rgba(0, 0, 0, 0.12);
    --border-radius: 10px;
    --transition-speed: 0.3s;
}
body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: var(--light-bg);
    color: var(--dark-text);
}
.taupier-archive-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 2rem;
    box-sizing: border-box;
}
.page-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}
.page-title {
    font-size: 2.8rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 1rem;
    line-height: 1.2;
}
.departement-intro {
    font-size: 1.2rem;
    margin: 1.5rem 0 1rem;
    color: var(--medium-text);
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}
.departement-slider {
    overflow-x: auto;
    white-space: nowrap;
    padding: 1rem 0;
    margin: 2rem 0;
    text-align: center;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
.departement-slider::-webkit-scrollbar {
    display: none;
}
.dep-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin: 0 7px;
    padding: 0.6rem 1rem;
    background: var(--secondary-color);
    color: var(--light-text);
    border-radius: var(--border-radius);
    text-decoration: none;
    font-size: 1rem;
    font-weight: 600;
    transition: background var(--transition-speed), transform 0.15s ease;
    min-width: 50px;
}
.dep-btn:hover {
    background: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px var(--shadow-light);
}
.dep-btn.active {
    background: var(--primary-color);
    box-shadow: inset 0 0 0 2px var(--light-text), 0 2px 5px var(--shadow-light);
    transform: translateY(0);
}
.shop-promo-banner {
    background-color: var(--light-bg);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    padding: 2rem;
    margin-bottom: 3rem;
    text-align: center;
    box-shadow: 0 5px 20px var(--shadow-light);
    transition: transform var(--transition-speed), box-shadow var(--transition-speed);
}
.shop-promo-banner:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px var(--shadow-medium);
}
.shop-promo-banner p {
    font-size: 1.25rem;
    color: var(--dark-text);
    margin-bottom: 1.5rem;
    font-weight: 500;
}
.shop-promo-banner .promo-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background-color: var(--secondary-color);
    color: var(--light-text);
    padding: 1rem 2.2rem;
    border-radius: var(--border-radius);
    text-decoration: none;
    font-weight: bold;
    font-size: 1.1rem;
    transition: background-color var(--transition-speed), transform var(--transition-speed), box-shadow var(--transition-speed);
    box-shadow: 0 4px 10px var(--shadow-light);
}
.shop-promo-banner .promo-button:hover {
    background-color: var(--primary-color);
    transform: translateY(-3px);
    box-shadow: 0 6px 15px var(--shadow-medium);
}
.taupier-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
    padding-bottom: 2rem;
}
.taupier-card-link {
    display: block;
    text-decoration: none;
    color: inherit;
}
.taupier-card {
    background: var(--light-text);
    border-radius: var(--border-radius);
    box-shadow: 0 5px 20px var(--shadow-light);
    transition: transform var(--transition-speed) ease, box-shadow var(--transition-speed) ease;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.taupier-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 30px var(--shadow-medium);
}
.taupier-card-inner {
    display: flex;
    flex-direction: column;
    height: 100%;
}
.taupier-media {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
    background: #eaeaea;
}
.taupier-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform var(--transition-speed) ease;
}
.taupier-card:hover .taupier-media img {
    transform: scale(1.05);
}
.taupier-thumbnail-placeholder {
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 4rem;
    color: #ccc;
    background: #f0f0f0;
    height: 100%;
}
.taupier-rating {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    background: rgba(0, 0, 0, 0.75);
    color: var(--light-text);
    padding: 0.6rem 0.8rem;
    font-size: 0.9rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
}
.stars-container .star {
    font-size: 1.1rem;
    margin-right: 3px;
}
.star.full, .star.half { color: var(--accent-color); }
.star.empty { color: #888; }
.rating-text {
    font-size: 0.85rem;
    opacity: 0.9;
}
.taupier-content {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.taupier-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin: 0 0 0.8rem;
    text-decoration: none;
}
.taupier-title:hover {
    text-decoration: underline;
    color: var(--secondary-color);
}
.taupier-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.2rem;
    font-size: 0.95rem;
    color: var(--medium-text);
    margin-bottom: 1rem;
}
.meta-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.meta-item span {
    font-weight: 600;
}
.taupier-excerpt {
    font-size: 1rem;
    color: var(--dark-text);
    margin-bottom: 1.5rem;
    line-height: 1.6;
    height: 3.8em;
    overflow: hidden;
    text-overflow: ellipsis;
}
.taupier-actions {
    display: flex;
    justify-content: space-between;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-top: auto;
}
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.8rem 1.2rem;
    border-radius: 8px;
    text-align: center;
    font-size: 0.95rem;
    font-weight: bold;
    cursor: pointer;
    transition: background-color var(--transition-speed), transform 0.15s ease, box-shadow var(--transition-speed);
    flex: 1 1 48%;
    min-width: 120px;
}
.btn-primary {
    background-color: var(--secondary-color);
    color: var(--light-text);
    box-shadow: 0 2px 5px var(--shadow-light);
}
.btn-primary:hover {
    background-color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: 0 4px 10px var(--shadow-medium);
}
.btn-secondary {
    background-color: var(--border-color);
    color: var(--dark-text);
    border: 1px solid var(--border-color);
    box-shadow: 0 2px 5px var(--shadow-light);
}
.btn-secondary:hover {
    background-color: #DCDCDC;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px var(--shadow-medium);
}
.archive-description-after-list {
    text-align: left;
    margin-top: 3rem;
    padding: 2rem;
    background-color: var(--light-text);
    border-radius: var(--border-radius);
    box-shadow: 0 5px 20px var(--shadow-light);
    line-height: 1.8;
    font-size: 1.1rem;
    color: var(--dark-text);
}
.archive-description-after-list p {
    margin-bottom: 1em;
}
@media (max-width: 768px) {
    .taupier-archive-container {
        padding: 0 1rem;
        margin: 1rem auto;
    }
    .page-title { font-size: 2rem; }
    .departement-intro { font-size: 1rem; }
    .dep-btn { padding: 0.5rem 0.8rem; font-size: 0.9rem; }
    .shop-promo-banner { padding: 1.5rem; margin-bottom: 2rem; }
    .shop-promo-banner p { font-size: 1rem; }
    .shop-promo-banner .promo-button { padding: 0.8rem 1.5rem; font-size: 1rem; }
    .taupier-list { grid-template-columns: 1fr; gap: 1.5rem; }
    .taupier-card-inner { flex-direction: column; }
    .taupier-content { padding: 1rem; }
    .taupier-title { font-size: 1.3rem; }
    .taupier-meta { flex-direction: column; gap: 0.5rem; }
    .taupier-excerpt { font-size: 0.9rem; }
    .btn { flex: 1 1 100%; }
    .archive-description-after-list { padding: 1rem; margin-top: 2rem; font-size: 1rem; }
}
</style>

<?php
get_footer();
?>
