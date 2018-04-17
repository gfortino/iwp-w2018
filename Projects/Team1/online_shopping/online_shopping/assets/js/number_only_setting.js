//该js文件用于对一些输入框进行只能输入数字的设置
$(function() {
    $("#long").numericInput({ allowFloat: true, allowNegative: true });
});$(function() {
    $("#wide").numericInput({ allowFloat: true, allowNegative: true });
});$(function() {
    $("#hight").numericInput({ allowFloat: true, allowNegative: true });
});
$(function() {
    $("#weight").numericInput({ allowFloat: true, allowNegative: true });
});

$(function() {
    $("#seuil_stock_alerte").numericInput({ allowFloat: true, allowNegative: true });
});
$(function() {
    $("#desired_stock").numericInput({ allowFloat: true, allowNegative: true });
});
$(function() {
    $("#suppliers_price").numericInput({ allowFloat: true, allowNegative: true });
});
$(function() {
    $("#tva_tx").numericInput({ allowFloat: true, allowNegative: true });
});
$(function() {
    $("#price").numericInput({ allowFloat: true, allowNegative: true });
});
$(function() {
    $("#cost_price").numericInput({ allowFloat: true, allowNegative: true });
});
$(function() {
    $("#price_min_ttc").numericInput({ allowFloat: true, allowNegative: true });
});