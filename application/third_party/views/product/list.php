<section class="admin-prod-wrap">
    <p>현재 상품 추가만 가능.<br>
    그 외 기능은 admin계정 요구사항 파악 후 구현예정.<br><br>
    </p>
    <a class="btn" href="/admin/add">상품추가</a>
    <table>
        <tr>
            <td>id</td>
            <td>상품명</td>
            <td>편집</td>
        </tr>
        <?php
        foreach($products as $prod){
        ?>
        <tr>
            <td><?=$prod->product_id?></td>
            <td><a href="#"><?=$prod->product_name?></a></td>
            <td class="btn-td">
                <a href="#">수정</a>
                <a href="#">삭제</a>
            </td>
        </tr>
        <?php
        }
        ?>

    </table>
</section>