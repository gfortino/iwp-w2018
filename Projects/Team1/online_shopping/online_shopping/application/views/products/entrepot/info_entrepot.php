<input type="hidden" id="base_url" value="<?php echo base_url()?>"/><!-- 用于js读取本地url -->

<div class="col-md-10 col-md-offset-1">
    <?php foreach ($entrepot as $un_entrepot): ?>
    <h5><?php echo $un_entrepot['label']?></h5>
    <h6><?php echo $un_entrepot['lieu']?>,    <?php echo $un_entrepot['pays_label'] ?></h6>

    <table class="table table-hover table-bordered">
        <tr>
            <td width="15%">描述</td>
            <td><?php echo $un_entrepot['description']?></td>
        </tr>
        <tr>
            <td>不同的产品数</td>
            <td><?php echo $un_entrepot['count_product']?></td>
        </tr>
        <tr>
            <td>
                产品总数
            </td>
            <td>
                <?php echo $un_entrepot['reel']?>
            </td>
        </tr>
        <tr>
            <td>
                最近的库存调拨
            </td>
            <td>
                <a href="<?php echo base_url('/index.php/products/show_stock_mouvements/?fk_entrepot='.$un_entrepot['rowid'])?>">全部列表</a>
            </td>
        </tr>
    </table>
    <?php endforeach; ?>
    <button type="button" onclick="window.location.href='<?php echo base_url('/index.php/products/show_entrepots')?>'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
        <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span>返回
    </button>
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th><font size="4"><b><?php echo lang('barcode')?></b></font></th>
            <th><font size="4"><b><?php echo lang('label')?></b></font></th>
            <th><font size="4"><b>数量</b></font></th>
            <th><font size="4"><b>投入平均价格(pmp)</b></font></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <?php foreach ($product_stock as $un_stock): ?>
            <tr>
                <td>
                    <?php echo $un_stock['barcode']?>
                </td>
                <td>
                    <?php echo $un_stock['label']?>
                </td>
                <td>
                    <?php echo $un_stock['reel']?>
                </td>
                <td>
                    <?php echo number_format($un_stock['pmp'],3)?>
                </td>
                <td>
                    库存调拨转移
                </td>
                <td>
                    合适的库存
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>