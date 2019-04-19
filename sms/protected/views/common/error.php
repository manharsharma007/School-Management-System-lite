<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404! File not found</title>
    <style type="text/css">
    *{font-family: calibri;text-decoration: none;}
    .container{width: 800px;margin: 0 auto;}
    h1{color:#f56954 !important;font-size: 100px;text-align: center;}
    hr {
    margin-top: 20px;
    margin-bottom: 20px;
    border: 0;
    border-top: 1px solid #eee;
}
    .text_small h3{font-weight: 100;font-size: 24px;color:#f56954 !important;}
    .text-danger {
    color: #a94442;
}
p {
    margin: 0 0 10px;
}
.text-info {
    color: #31708f;
}
.btn.btn-default:hover, .btn.btn-default:active, .btn.btn-default.hover {
    background-color: #f4f4f4!important;
}
.btn {
    font-weight: 500;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    border: 1px solid transparent;
    -webkit-box-shadow: inset 0px -2px 0px 0px rgba(0, 0, 0, 0.09);
    -moz-box-shadow: inset 0px -2px 0px 0px rgba(0, 0, 0, 0.09);
    box-shadow: inset 0px -1px 0px 0px rgba(0, 0, 0, 0.09);
}
.btn-default {
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}
.btn.btn-default {
    background-color: #fafafa;
    color: #666;
    border-color: #ddd;
    border-bottom-color: #ddd;
}
.pull-right {
    float: right !important;
}
    </style>
</head>
<body>
    <div class="container">
        <div class="text_big">
            <h1>404!</h1>
        </div>
        <div class="text_small">
            <h3 class="text-red" style="text-align:left"><i class="fa fa-warning text-red"></i> Not Found (#404)</h3>
        <hr>
            <p class="text-danger">Page not found.</p>
            <p class="text-info">The above error occurred while the Web server was processing your request.</p>
            <p class="text-info">Please contact us if you think this is a server error. Thank you.</p>
        <hr>
        <h4>
            <a class="btn btn-default" href="javascript:history.back()" onclick="javascript:history.back()"><i class="fa fa-arrow-circle-left"></i> Go Back</a>     <div class="pull-right"><a class="btn btn-default" href="<?= SITE_URL ?>"><i class="fa fa-home"></i> Return Home</a></div>
        </h4>
        </div>
    </div>
</body>
</html>