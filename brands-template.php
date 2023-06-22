<?php
/*
Template Name:  Brand Template Name
*/


get_header();


function get_brand_groups()
{
	global $wpdb;
	return $wpdb->get_results(<<<SQL
		SELECT COUNT(t.term_id) num, CONCAT('{', GROUP_CONCAT(CONCAT('"', t.slug, '":"', t.name, '"')), '}') jsondata,
		CASE
			WHEN ASCII(UPPER(LEFT(t.name, 1))) BETWEEN 65 AND 90 THEN UPPER(LEFT(t.name, 1))
			ELSE '0-9'
		END letter,
		COUNT(*) AS group_count
		FROM {$wpdb->terms} t 
		JOIN {$wpdb->term_taxonomy} tt ON t.term_id = tt.term_id
			WHERE tt.taxonomy = "pa_brand" 
			GROUP BY letter
	SQL);
}

?>

<main id="primary" class="site-main">
	<div class="container">
		<h1><?= get_the_title(); ?></h1>
		<?php
		$chars = range('a', 'z');
		$letter = '';
		foreach ($chars as $key => $char) {
			$letter .= '<li><a href="#' . $char . '">' . $char . '</a></li>';
		}

		echo <<<HTML
			<ul class="letters">
				<li><a href="#0-9">0-9</a></li>
				{$letter}
			</ul>
		HTML;

		$brand_groups = get_brand_groups();
		// $terms = get_terms("pa_brand");
		foreach ($brand_groups as $group) {
			$group_atts = json_decode($group->jsondata);
			$current_group_html = '';
			foreach ($group_atts as $att_key => $att_val) {
				$current_group_html .= '<li class="result__content_item"><a href="http://cross/brand/' . $att_key . '">' . $att_val . '</a></li>';
			}

			echo <<<HTML
				<div class="result" id={$group->letter}>
					<p class="result__title">$group->letter</p>
					<ul class="result__content">
						$current_group_html
					</ul>
					<div class="result__wrap-btn">
						<a href="#back">back to top</a>
					</div>
				</div>
			HTML;
			// var_dump($term);
			// var_dump($term->term_id);
			// echo get_term_link($term->term_id);
			// echo "<option>" . $term->name . "</option>";
		}
		?>
	</div>
</main><!-- #main -->

<?php
get_footer();
