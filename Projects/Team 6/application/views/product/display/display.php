<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<div class="row">
    <table style ="margin: 100px;border-collapse: separate;
    border-spacing: 30px;10px solid black">
    <?php foreach ($data as $item): ?>

      <tr style ="cellspacing:30px;">

        <th style ="margin:100px;"><?php echo $item->name ?></td>
        <th><?php echo $item->price ?>$</td>
        <?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true && $_SESSION['is_admin'] == false) : ?>
        <th><a href="<?php echo base_url(); ?>product/buy/<?php echo $item->id ?>">Buy</a></td>
        <?php endif; ?>
      </tr>

<?php endforeach; ?>
  </table>
	</div>
</div><!-- .container -->
