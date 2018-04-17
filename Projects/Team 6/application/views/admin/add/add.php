<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container" style ="margin: 100px;">
	<div class="row">
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= validation_errors() ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="col-md-12">
			<div class="page-header">
				<h1 style="">Add Product</h1>
			</div>
			<?= form_open() ?>
				<div class="form-group">
					<label for="username">Name of the Product</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Name of the product">
				</div>
				<div class="form-group">
					<label for="password">Price</label>
					<input type="number" class="form-control" id="price" name="price" placeholder="Price of the product">
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-default" value="Add">
				</div>
			</form>
		</div>
	</div><!-- .row -->
</div><!-- .container -->
