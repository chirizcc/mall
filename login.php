<?php 
include 'logo.php'; 
session_start();
if(!empty($_SESSION['isLogin']) && $_SESSION['isLogin'] == 1){
    header('location:index.php');
}
?>

<div class="login-content">
    <!--登录模块开始-->
    <div class="login">
        <!--标题开始-->
        <div class="title">
            <h2>账号登录</h2>
            <?php
            switch ($_GET['state']) {
                case '1':
                    echo '<center>请输入用户名跟密码</center>';
                    break;

                case '2':
                    echo '<center>用户名不能为空</center>';
                    break;
                
                case '3':
                    echo '<center>密码不能为空</center>';
                    break;

                case '4':
                    echo '<center>用户名不存在或没有权限登录</center>';
                    break;

                case '5':
                    echo '<center>密码错误</center>';
                    break;
                    
                default:
                    # code...
                    break;
            }
            ?>
        </div>
        <!--标题结束-->

        <!--登录表单开始-->
        <div class="loginForm">
            <form action="login_action.php" method="post">
                <div class="formInput userName"><input type="text" name="userName" placeholder="用户名"></div>
                <div class="gap20"></div>
                <div class="formInput password"><input type="password" name="password" placeholder="密码"></div>
                <div class="loginButton">
                    <div class="findPWD">
                        <span class="floatL"><a href="#">找回密码？</a></span>
                        <span class="floatR"><a href="register.php">注册账号</a></span>
                        <div class="clear"></div>
                    </div>
                    <input type="submit" value="提交">
                </div>
            </form>
        </div>
        <!--登录表单结束-->
    </div>
    <!--登录模块结束-->
</div>

<div class="gap10"></div>

<?php include 'footer.php'; ?>