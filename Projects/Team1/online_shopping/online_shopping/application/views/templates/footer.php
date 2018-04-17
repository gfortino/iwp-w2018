

        <div align="right" class="col-md-10 col-md-offset-1">
            </br>
            </br>
            </br>
            </br>
            </br>

            <em><font color="66CCFF">v0.9.8</font> &copy; all rights of TEAM1 2017/04/10</em>
        </div>
        <div id="snackbar" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScriptlugins) -->
        <!-- Include all compiled plugins (below), or inc plude individual files as needed -->
        <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
    </body>
</html>
<script>
    //显示提示函数
    function show_snackbar(message,timeout){
        var snackbarContainer = document.querySelector('#snackbar');
        var data = {
            message: message,
            timeout: timeout,
        };
        snackbarContainer.MaterialSnackbar.showSnackbar(data);
    }
</script>