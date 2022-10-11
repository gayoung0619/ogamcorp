<?
include_once "../inc/function.php";
include_once "../inc/cafe24_env.php";
?>
<html>
<header>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" crossorigin="anonymous" async></script>
</header>

<body>
<div>
    <button type="button" id="login">로그인요청 버튼</button>
</div>

<script>
    $(function(){
        $('#login').click(function(){
            alert('클릭');
        })
    })
</script>
</body>
</html>

