// 각 상품 이미지 마우스 호버 시, 뒤에 있는 이미지 보이기
$(document).on('mouseover','.main-box', function(){
    $(this).find('.front').hide();
    $(this).find('.back').show();
});

$(document).on('mouseout','.main-box', function(){
    $(this).find('.back').hide();
    $(this).find('.front').show();
});

// 해당 상품 품절인 경우, + - 버튼 클릭시 alert
$(document).on('click','.out-of-stock', function(){
    alert("해당 상품은 품절입니다.");
    return false;
});

// 정렬 기준 선택시, 해당 데이터 로드
// 현재 상품 유형이 꽃인 경우만 구현
$(document).on('click', '.prod-sorting-std', function (e) {
    var cate = $('.cate-info').attr('data-cate');
    var cate_value = $('.cate-info').attr('data-cate_value');
    var sorting = $(this).data('sorting');
    var url = '/product/sort/1/'+cate+'/'+cate_value+'/'+sorting;

    $('.main-prod-list-wrap').load(url);

    //전체 정렬기준 css 원상복구
    $(this).closest('.prod-sorting').find('li a').css('border-bottom', '0px');

    //선택한 정렬기준 css 변경
    $(this).closest('li a').css('border-bottom', '1.5px solid #f44336');
});

// 카테고리 선택시, 해당 데이터 로드
// 현재 상품 유형이 꽃인 경우만 구현
$(document).on('click', '.cate-all', function (e) {
    var cate = $(this).data('cate');
    var cate_value = $(this).data('cate_value');
    var url = '/product/sort/1/'+cate+'/'+cate_value+'/name';

    $(this).closest('ul.prod-cate').find('input[type=hidden]').attr('data-cate', cate);
    $(this).closest('ul.prod-cate').find('input[type=hidden]').attr('data-cate_value', cate_value);
    $('.main-prod-list-wrap').load(url);

    //전체 카테고리 css 및 카테고리명 원상복구
    $(this).closest('.prod-cate').find('ul').css('border-color', '#999999');
    $(this).closest('.prod-cate').find('p span').each(function(){
        $(this).html($(this).data('cate'));
    });

    //선택한 카테고리 css 및 카테고리명 선택한 카테고리값으로 변경
    $(this).closest('ul').find('p span').html($(this).html());
    $(this).closest('ul').css('border-color', '#f44336');

    //전체 정렬기준 css 원상복구
    $('.prod-sorting').find('li a').css('border-bottom', '0px');

    //정렬 기준 (가나다순)으로 변경
    $('.prod-sorting-std[data-sorting="name"]').css('border-bottom', '1.5px solid #f44336');

    //검색창 초기화 : 검색 후 검색창에 계속 남아있는데, 카테고리를 선택할 경우 사라지도록 처리
    $('.search-input').val('');
});