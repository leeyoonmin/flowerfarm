<section class="add-product-wrapper">
    <?php echo $error;?>
    <?php echo form_open_multipart('admin/add');?>
        <div class="input-area">
            <h1>상품업로드</h1>
            <div>
                <input type="text" name="p_name" placeholder="품목명">
            </div>
            <div>
                <label><input type="radio" name="p_type" value="1">꽃</label>
                <label><input type="radio" name="p_type" value="2">부자재</label>
            </div>
            <div>
                <input type="number" name="p_price_w" placeholder="도매가격">
            </div>
            <div>
                <input type="number" name="p_price_r" placeholder="소매가격">
            </div>
            <div>
                <input type="number" name="p_amount" placeholder="수량">
            </div>
            <div>
                <input type="text" name="p_content" placeholder="설명">
            </div>
            <div>
                <label for="p_cate_kind">품종
                    <select id="p_cate_kind" name="p_cate_kind">
                    <?php foreach($p_kinds as $kind){ ?>
                        <option value="<?=$kind->kind_id?>"><?=$kind->kind_name?></option>
                    <?php
                    }
                    ?>
                    </select>
                </label>
            </div>
            <div>
                <label for="p_cate_shape">꽃형태
                    <select id="p_cate_shape" name="p_cate_shape">
                        <option value="line">라인</option>
                        <option value="form">폼</option>
                        <option value="mass">매스</option>
                        <option value="filler">필러</option>
                        <option value="green">그린소재</option>
                    </select>
                </label>
            </div>
            <div>
                <label for="p_cate_color">색깔
                    <select id="p_cate_color" name="p_cate_color">
                        <option value="red">빨강</option>
                        <option value="orange">주황</option>
                        <option value="yellow">노랑</option>
                        <option value="green">초록</option>
                        <option value="blue">파랑</option>
                        <option value="purple">보라</option>
                        <option value="white">흰색</option>
                        <option value="pink">분홍</option>
                    </select>
                </label>
            </div>
            <div>
                <label for="image_upload">메인 이미지<input type="file" name="images[]" size="50" class="image_upload" multiple/></label>
            </div>
            <div>
                <label for="image_upload">서브 이미지<input type="file" name="images[]" size="50" class="image_upload" multiple/></label>
            </div>
            <div>
                <label for="image_upload">기타 이미지<input type="file" name="images[]" size="50" class="image_upload" multiple/></label>
            </div>
            <div class="submit-btn">
                <input type="submit" value="저장">
            </div>
        </div>
    </form>
</section>
