// 헤더 - 쿠키 저장
function setCookie(name, value, expiredays){
    var cookie = name + "=" + value + "; path=/;";
    if (typeof expiredays != 'undefined') {
        var todayDate = new Date();
        todayDate.setHours(24);
        cookie += "expires=" + todayDate.toUTCString() + ";"
    }
    document.cookie = cookie;
}

// 헤더 - 쿠키 가져오기
function getCookie(name) {
    var value = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
    return value? value[2] : null;
};

// 헤더 - x버튼 클릭 시, 상단 배너 숨기고 하루 동안 보이지 않기
$(document).on('click', '.top-banner-hide', function () {
    $('.banner-area').slideUp();
    setCookie('top-banner', '1', 1);
});

//화면 로드시 기본 동작 함수
function basics(){
    // 쿠키값이 존재하는 경우, 상단 배너 숨기기
    if(getCookie('top-banner')){
        $('.banner-area').hide();
    }

    // 카트 컨테이너 숨기기
    $(".cart-container").hide();

    // 카트 버튼 토글
    $(".cart-head").click(function(){
        $(".cart-container").toggle(200);
    });

    //공공데이터 발표시 탑배너 보이지 않도록
    // $('.banner-area').hide();

}

//검색하기 (검색아이콘 클릭, 엔터)
function search(){
    var keyword = $('.search-input').val();
    if(keyword == ''){ //검색어를 입력하지 않은 경우 alert
        alert('검색어를 입력해주세요.');
        return;
    }
    var url = '/product/search/'+encodeURIComponent(keyword);
    // 각 view의 wrapper div에 content-wrapper 클래스가 있으면 검색 결과 로드됨.
    $('.content-wrapper').load(url, function () {
        basics();
        $('.cate-info').attr('data-cate', 'search'); //hidden태그에 카테고리명 지정
        $('.cate-info').attr('data-cate_value', encodeURIComponent(keyword)); //hidden태그에 카테고리값 지정
        $('.prod-cate-all').css('border-color', '#999999'); //전체 카테고리의 css 없애기
    });
}

//화면 로드시 기본 동작 수행
$(document).ready(function(){
    basics();
});


// 헤더 - 검색시 검색 결과 load
$(document).on('click', '.search-icon', function (e) {
    search();
});


// 장바구니 - 상품 수량 제어
// x - 1(수량추가) / 0(수량감소)
// data - 상품id, 상품명, 상품가격 정보를 array에 담음
// 어디에서 +, - 버튼을 클릭했는지(after 변수)에 따라 처리를 달리함
// after - cart(장바구니 페이지) / main(메인 페이지) / slide(슬라이드 카트)
function cart_ajax(x, data, after){
    $.ajax({
        type: 'post',
        url: '/cart/add_sub_Cart/'+x,
        dataType: "json",
        data: data,
        success: function (res) {
            if(after == 'cart'){
                if(res == 'max_err'){
                    alert('재고 수량을 초과했습니다.');
                    return;
                }
                location.reload();
            }else if(after == 'main'){
                 load_cart();
                if(res == 'err'){
                    alert('장바구니에 존재하지 않는 품목입니다.');
                }else if(res == 'max_err'){
                    alert('재고 수량을 초과했습니다.');
                }
            }else if(after == 'slide'){
                load_cart();
                if(res == 'max_err'){
                    alert('재고 수량을 초과했습니다.');
                }
            }
        },
        error:function(request,status,error){
            alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }

    });
}

//슬라이드 카트 새로고침
function load_cart(){
    $('.cart-container').load('/cart/get', function(){
        if($(this).is(':hidden')){// 카트 컨테이너가 닫혀있다면, 열렸다가 다시 닫기
            $(".cart-container").show();
            setTimeout(function() { $(".cart-container").hide(); }, 800);
        }
    });
}

// 장바구니 수량 제어 - 메인 페이지 및 슬라이드 카트에서 +, - 버튼 클릭하는 경우
$(document).on('click', '.cart-plus-minus', function (e) {
    var x = '1'; // plus인 경우,
    if($(this).data('check') == 'minus') {
        x = '0'; // minus인 경우,
    }
    var p_id = $(this).closest('li').data('pid');
    var p_price = $(this).closest('li').data('price');
    var p_name = $(this).closest('li').data('name');

    var data = { // 장바구니에 session에 저장할 데이터
      p_id : p_id,
      p_price : p_price,
      p_name : p_name
    };

    var after = $(this).data('after');

    cart_ajax(x, data, after);
    e.preventDefault();
});

// 장바구니 수량 제어 - 장바구니 페이지에서 +, - 버튼 클릭하는 경우
$(document).on('click', '.cart-plus-minus-tb', function (e) {
    var x = '1'; // plus인 경우,
    if($(this).data('check') == 'minus') {
        x = '0'; // minus인 경우,
    }

    var p_id = $(this).closest('tr').data('pid');
    var p_price = $(this).closest('tr').data('price');
    var p_name = $(this).closest('tr').data('name');

    var data = { // 장바구니에 session에 저장할 데이터
        p_id : p_id,
        p_price : p_price,
        p_name : p_name
    };

    var after = $(this).data('after');

    cart_ajax(x, data, after);

    e.preventDefault();
});



