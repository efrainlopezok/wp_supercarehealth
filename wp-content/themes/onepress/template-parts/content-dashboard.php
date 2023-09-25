<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package OnePress
 */
$current_user = wp_get_current_user();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="container">
			<div class="dashboard-header">Welcome <strong><?php echo $current_user->display_name; ?></strong></div>
		</div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<div class="container">
			<div class="dashboard-tabs">
				<ul>
					<li><a href="#personal-info" class="active">Personal Info</a></li>
					<li><a href="#orders">Orders</a></li>
				</ul>
			</div>
			<div class="dashboard-content">
				<div class="content-display active" id="personal-info">
					<h3>Personal Info</h3>
					<table>
						<tbody>
							<tr>
								<th><?php esc_html_e( 'Full Name', 'onepress' ); ?></th>
								<td><?php echo esc_attr( get_the_author_meta( 'full_name_user', $current_user->ID ) ); ?></td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'Phone', 'onepress' ); ?></th>
								<td><?php echo esc_attr( get_the_author_meta( 'phone_user', $current_user->ID ) ); ?></td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'Address', 'onepress' ); ?></th>
								<td><?php echo esc_attr( get_the_author_meta( 'address_user', $current_user->ID ) ); ?></td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'City', 'onepress' ); ?></th>
								<td><?php echo esc_attr( get_the_author_meta( 'city_user', $current_user->ID ) ); ?></td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'State', 'onepress' ); ?></th>
								<td><?php echo esc_attr( get_the_author_meta( 'state_user', $current_user->ID ) ); ?></td>
							</tr>
							<tr>
								<th><?php esc_html_e( 'Zip Code', 'onepress' ); ?></th>
								<td><?php echo esc_attr( get_the_author_meta( 'zip_code_user', $current_user->ID ) ); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="content-display" id="orders">
					<h2>Orders</h2>
					<table>
						<thead>
							<tr>
								<th><?php esc_html_e( 'Order Number', 'onepress' ); ?></th>
								<th><?php esc_html_e( 'Order Date', 'onepress' ); ?></th>
								<th><?php esc_html_e( 'Customer Name', 'onepress' ); ?></th>
								<th><?php esc_html_e( 'Customer Email', 'onepress' ); ?></th>
								<th><?php esc_html_e( 'Customer Address', 'onepress' ); ?></th>
								<th><?php esc_html_e( 'CPAP Mask Style', 'onepress' ); ?></th>
								<th><?php esc_html_e( 'Supplies', 'onepress' ); ?></th>
								<th><?php esc_html_e( 'Charge Co-Insurance', 'onepress' ); ?></th>
								<th><?php esc_html_e( 'Notes', 'onepress' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$current_id = $current_user->ID;
							global $wpdb;
							$table_name = "wp_user_orders";
							$user_c = $current_id;
							$orders = $wpdb->get_results("SELECT * FROM wp_user_orders WHERE customer_id = $current_id");
							foreach($orders as $order){
								echo '<tr>';
									echo '<td>'.$order->id.'</td>';
									echo '<td>'.$order->order_date.'</td>';
									echo '<td>'.esc_attr( get_the_author_meta( 'full_name_user', $current_id ) ).'</td>';
									echo '<td>'.$order->customer_email.'</td>';
									echo '<td>'.$order->customer_address.'</td>';
									echo '<td>'.$order->customer_cpap_m_style.'</td>';
									echo '<td>'.$order->customer_supplies.'</td>';
									echo '<td>'.$order->customer_charge_co_insurance.'</td>';
									echo '<td>'.$order->notes.'</td>';
								echo '</tr>';
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.dashboard-tabs ul li a').on('click', function(e){
					e.preventDefault();
					jQuery('.dashboard-tabs ul li a').removeClass('active');
					jQuery(this).addClass('active');
					var nav = jQuery(this).attr('href');
					jQuery('.content-display').removeClass('active');
					jQuery(nav).addClass('active');
				});
			});
		</script>
	</div><!-- .entry-content -->
</article><!-- #post-## -->

