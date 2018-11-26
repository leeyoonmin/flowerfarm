<script src="/static/js/join.js"></script>
<div class="join-wrapper content-wrapper">
    <div class="join-header">
        <img src="/static/img/<?php if($userType == 'user'){ echo "join_user_s.png";} else{ echo "join_company_s.png";}?>">
    </div>
    <section class="join-main">
        <?php echo form_open_multipart('auth/addUser', array('onsubmit' => 'return joinSubmit();'));?>
            <div class="input-area">
                <div class="input-row">
                    <div>
                        <input type="text" name="name" placeholder="이름" maxlength="8" required>
                    </div>
                </div>
                <div class="input-row">
                    <div class="double-check">
                        <input type="text" name="cellphone" placeholder="휴대폰번호 (-포함 입력)" pattern="\d{3}-\d{3,4}-\d{4}" required>
                        <button type="button" id="phone-certi">중복확인</button>
                    </div>
                    <div class="error-msg">
                    </div>
                </div>
                <div class="input-row">
                    <div class="double-check">
                        <input type="text" name="id" placeholder="아이디 (특수문자 입력불가)" data-valid="0" class="join-id" pattern="[A-Za-z0-9]{4,10}" maxlength="10" required>
                        <button class="id-check-btn" type="button">중복확인</button>
                    </div>
                    <div class="error-msg">
                    </div>
                </div>
                <div class="input-row">
                    <div>
                        <input class="join-pw" type="password" name="pw" placeholder="비밀번호 (8~12자리)" data-valid="0" maxlength="12" required>
                    </div>
                    <div class="error-msg">
                    </div>
                </div>
                <div class="input-row">
                    <div>
                        <input class="join-pw-check" type="password" name="pw_check" placeholder="비밀번호 확인" data-valid="0" maxlength="12" required>
                    </div>
                    <div class="error-msg">
                    </div>
                </div>
                <?php if($userType == 'user') {
                ?>
                    <input type="hidden" name="type" value="5">
                <?php
                }
                ?>
            </div>
        <?php if($userType == 'company'){
        ?>
            <div class="input-area join-company">
                <div class="select-user-type">
                    <span>사업자유형</span>
                    <div class="inline-label">
                        <label for="farm">
                        <input type="radio" id="farm" name="type" value="2" required>
                        농가</label>
                    </div>
                    <div class="inline-label">
                        <label for="wholesale">
                        <input type="radio" id="wholesale" name="type" value="3">
                        도매</label>
                    </div>
                    <div class="inline-label">
                        <label for="retail">
                        <input type="radio" id="retail" name="type" value="4">
                        소매</label>
                    </div>
                </div>
                <div>
                    <input type="text" name="shop_name" placeholder="상호명" maxlength="15" required>
                </div>
                <div>
                    <input type="text" name="shop_phone" placeholder="전화번호 (- 포함 입력)" required>
                </div>
                <div>
                    <input type="text" name="certificate_num" placeholder="사업자번호 (- 포함 입력)" pattern="\d{3}-\d{2}-\d{5}" required>
                </div>
                <div class="input-row">
                    <div class="certificate">
                        <input class="upload-name" value="사업자등록증" disabled="disabled">
                        <label for="image-upload">파일선택</label>
                        <input type="file" name="userfile" size="50" id="image-upload" class="upload-hidden" data-valid="0" required/>
                    </div>
                    <div class="error-msg">
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
            <div class="terms">
                <p>본인은 만 14세 이상이며, <a>꽃팜 구매회원 이용약관</a>, <a>개인정보 수집 및 이용</a> 내용을 확인하였으며 동의합니다.</p>
            </div>
            <div class="submit-btn">
                <input type="submit" id="join-submit" value="동의하고 회원가입">
            </div>
        </form>
    </section>
</div>
