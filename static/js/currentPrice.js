function setGongpan_busan(value) {
    if (value == "") {
        return;
    }
    else {
        $.ajax({
            url: "../currentPrice/get_mclass",
            type: "POST",
            data: {gongpanName_busan: value},
            success: function (data) {
                $(".mclasszone_busan").html(data);

            },
            //에러발생시,
            error: function (request, status, error) {
                alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
            }
        });

    }
}

function setMclass_busan(value) {

    var gongpanValue = $("select[name='gongpan_busan']").val();
    if (value == "") {
        return;
    }
    else {
        $.ajax({
            url: "../currentPrice/get_sclass",
            type: "POST",
            data: {gongpanName_busan: gongpanValue, mclassname_busan: value},
            success: function (data) {
                $(".sclasszone_busan").html(data);

            },
            //에러발생시,
            error: function (request, status, error) {
                alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
            }
        });

    }
}

$(document).on('click', '.submitDatas_busan', function (e) {
    var gongpan = $("select[name='gongpan_busan']").val();
    var mclass = $("select[name='mclassname_busan']").val();
    var sclass = $("select[name='sclassname_busan']").val();
    if (sclass != "") {
        $.ajax({
            url: "../currentPrice/getgraph",
            type: "POST",
            datatype: 'JSON',
            data: {gongpanName_busan: gongpan, mclassname_busan: mclass, sclassname_busan: sclass},
            error: function (request, status, error) {
                alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
            },
            success: function (data) {
                $("#graphdiv_busan").html(data)

            }
        });
        $.ajax({
            url: "../currentPrice/get_chart",
            type: "POST",
            datatype: 'JSON',
            data: {gongpanName_busan: gongpan, mclassname_busan: mclass, sclassname_busan: sclass},
            error: function (request, status, error) {
                alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
            },
            success: function (data) {
                $("#chartdiv_busan").html(data);
            }
        });
    }
    else {
        alert("품명을 선택하세요");
    }

});

function setGongpan_other(value) {
    if (value == "") {
        return;
    }
    else {
        $.ajax({
            url: "../currentPrice/get_sclass",
            type: "POST",
            data: {gongpanName_other: value},
            success: function (data) {
                $(".sclasszone_other").html(data);

            },
            //에러발생시,
            error: function (request, status, error) {
                alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
            }
        });

    }
}

// function setMclass_other(value) {
//
//     var gongpanValue = $("select[name='gongpan_other'").val();
//     if(value==""){
//         return;
//     }
//     else {
//         $.ajax({
//             url:"../currentPrice/get_sclass",
//             type: "POST",
//             data: { gongpanName_other:gongpanValue, mclassname_other:value },
//             success: function(data){
//                 $(".sclasszone_other").html(data);
//
//             },
//             //에러발생시,
//             error:function(request,status,error){
//                 alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
//             }
//         });
//
//     }
// }
$(document).on('click', '.submitDatas_other', function (e) {
    var gongpan = $("select[name='gongpan_other']").val();
    var mclass = $("select[name='mclassname_other']").val();
    var sclass = $("select[name='sclassname_other']").val();
    if (sclass != "") {
        $.ajax({
            url: "../currentPrice/getgraph",
            type: "POST",
            datatype: 'JSON',
            data: {gongpanName_other: gongpan, mclassname_other: mclass, sclassname_other: sclass},
            error: function (request, status, error) {
                alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
            },
            success: function (data) {
                $("#graphdiv_other").html(data);
                // $('#mainContents').load('../mypage/reload');
            }
        });
    }
    else {
        alert("품명을 선택하세요");
    }

});
$(document).on('click', '.graphBtn', function () {
    $('.graphBtn').css({
        "background": "#cb3532",
        "color": "white"
    });
    $('.chartBtn').css({
        "background": "white",
        "color": "#cb3532"
    });
    $("#graphdiv_busan").css({
        "display": "inherit"
    });
    $("#chartdiv_busan").css({
        "display": "none"
    });
    $(".selectZone_other").css({
        "display": "inherit"
    });

});
$(document).on('click', '.chartBtn', function () {
    $('.chartBtn').css({
        "background": "#cb3532",
        "color": "white"
    });
    $('.graphBtn').css({
        "background": "white",
        "color": "#cb3532"
    });
    $("#graphdiv_busan").css({
        "display": "none"
    });
    $("#chartdiv_busan").css({
        "display": "inherit"
    });
    $(".selectZone_other").css({
        "display": "none"
    });
    var gongpan = $("select[name='gongpan_busan']").val();
    var mclass = $("select[name='mclassname_busan']").val();
    var sclass = $("select[name='sclassname_busan']").val();
    if (sclass != "") {
        $.ajax({
            url: "../currentPrice/get_chart",
            type: "POST",
            datatype: 'JSON',
            data: {gongpanName_busan: gongpan, mclassname_busan: mclass, sclassname_busan: sclass},
            error: function (request, status, error) {
                alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
            },
            success: function (data) {
                $("#chartdiv_busan").html(data);
                // $('#mainContents').load('../mypage/reload');
            }
        });
    }
    else {
        return;
    }



});