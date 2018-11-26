<div class="member-wrapper content-wrapper">
    <div class="member-header">
        <img src="/static/img/login_logo.png">
    </div>
    <section class="member-main">
        <div class="main-wrapper">
            <form action="/auth/authentication" method="post">
                <div class="login-input">
                    <div class="field-wrap">
                        <div class="input-field">
                            <label class="input-field-label">
                                <div class="input-field-input">
                                    <input class="member-input loginIdInput" name="id" placeholder="아이디">
                                </div>
                            </label>
                        </div>
                        <div class="expand-field">
                            <div classs="error-message"></div>
                        </div>
                    </div>
                    <div class="field-wrap">
                        <div class="input-field">
                            <label class="input-field-label">
                                <div class="input-field-input">
                                    <input type="password" class="member-input loginIdInput" name="pw" placeholder="비밀번호">
                                </div>
                            </label>
                        </div>
                        <div class="expand-field">
                            <div classs="error-message"></div>
                        </div>
                    </div>
                </div>
                <div class="login-captcha"></div>
                <div class="login-util">
                    <input type="checkbox" id="remember-id" class="checkbox-style" />
                    <label for="remember-id">아이디 저장</label>
                    <a class="find-id-password" href="">아이디/비밀번호 찾기</a>
                </div>
                <div class="login-keep-state-alert">개인 정보 보호를 위해 본인 기기에서만 이용해주세요.</div>
                <div class="login-trigger-wrap">
                    <button class="login-trigger login">로그인</button>
                    <a class="login-trigger register" href="/auth/join">회원가입</a>
                </div>
            </form>
        </div>
    </section>
</div>