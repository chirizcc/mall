<?php include 'logo.php';?>
<div class="regi-content">
    <div class="title">
        注册360账号
    </div>
    <div class="gap2"></div>
    <div class="registerForm">
        <div class="formBox">
            <?php
            switch ($_GET['state']) {

                case '1':
                    echo '<center>用户名不能为空</center>';
                    break;
                
                case '2':
                    echo '<center>密码不能为空</center>';
                    break;

                case '3':
                    echo '<center>密码与确认密码不同</center>';
                    break;

                case '4':
                    echo '<center>验证码为空</center>';
                    break;

                case '5':
                    echo '<center>验证码错误</center>';
                    break;

                case '6':
                    echo '<center>用户名已存在</center>';
                    break;

                case '7':
                    echo '<center>注册失败</center>';
                    break;
                   
                case '8':
                    echo '<center>用户名或密码不符合规则</center>';
                    break;

                default:
                    break;
            }
            ?>
            <form action="register_action.php" method="post">
                <div class="formInput userName"><input type="text" name="userName" placeholder="用户名(任意字母数字下划线，以字母开头4-10位)"></div>
                <div class="gap20"></div>
                <div class="formInput password"><input type="password" name="password" placeholder="密码(任意8-20位)"></div>
                <div class="gap20"></div>
                <div class="formInput password"><input type="password" name="password2" placeholder="确认密码(任意8-20位)"></div>
                <div class="gap20"></div>
                <div class="authInput floatL"><input type="text" name="auth" placeholder="请输入验证码"></div>
                <div class="authImage floatR"><img src="public/yzm.php" onclick="this.src='./public/yzm.php?id='+Math.random();"></div> 
                <div class="gap20"></div>
                <div class="gap20"></div>
                <div class="submit">
                    <input type="submit" value="注册">
                </div>
            </form>
            <p>点击“注册”，即表示您已同意并愿意遵守《360用户服务条款》</p>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>