/***********************************************************
        화면 로드온 이벤트
***********************************************************/
$(window).load(function(e){
  addConfIDEvent();
  var count = 0;
  $('.divJoin .divText .intro.hidden').transition({
    animation : 'fade up',
    duration  : 2000,
    interval  : 2500,
    onComplete : function(){
      $(this).transition({
        animation : 'fade up',
        duration  : 500,
        onComplete : function(){
          count++;
          if(count==3){
            $('.divJoin .divText h1.intro.show').transition({
              animate:'fade up',
              duration:1500,
              onComplete : function(){
                $('.divJoin .divInput').transition({
                  animate:'fade up',
                  duration:1500,
                  onComplete : function(){
                    $('.divJoin .divInput .input.text.name').focus();
                  }
                });
              }
            });
          }
        }
      });
    }
  });
});

var name,id,password,tel1,tel2,tel3="";

/***********************************************************
        이름 스텝 확인버튼 클릭
***********************************************************/
$('.divJoin .divInput .button.name').click(function(e){
  name = $('.divJoin .divInput .input.name').val();
  if(name == ""){
    $('.divJoin .divText .intro.show').transition({
      animate:'fade up',
      duration:500,
      onComplete : function(){
        $('.divJoin .divText .intro.show').html('입력칸이 비었네요</br>이름을 입력해주세요');
        $('.divJoin .divText .intro.show').transition({
          animate:'fade up',
          duration:500,
          onComplete : function(){
            $('.divJoin .divInput .input.text.name').focus();
          }
        });
      }
    });
  }else{
    var nameCnt = 0;
    $('.divJoin .divText .intro.show, .divJoin .divInput').transition({
      animate:'fade up',
      duration:500,
      interval  : 200,
      onComplete : function(){
        nameCnt++;
        if(nameCnt == 2){
          $('.divJoin .divText .static.name').text(name);
          var count = 0;
          $('.divJoin .divText .id.hidden').transition({
            animation : 'fade up',
            duration  : 1500,
            interval  : 2000,
            onComplete : function(){
              $(this).transition({
                animation : 'fade up',
                duration  : 500,
                onComplete : function(){
                  count++;
                  if(count==2){
                    $('.divJoin .divText .id.show').transition({
                      animate:'fade up',
                      duration:1500,
                      onComplete : function(){
                        $('.divJoin .divInput .input.text').val('');
                        $('.divJoin .divInput .input.text').addClass('id');
                        $('.divJoin .divInput .input.text').addClass('inputID');
                        $('.divJoin .divInput .input.text').removeClass('name');
                        addConfIDEvent();
                        $('.divJoin .divInput .input.button').addClass('id');
                        $('.divJoin .divInput .input.button').removeClass('name');
                        $('.divJoin .divInput .input.button').css('display','inline-block');
                        $('.divJoin .divInput .input.button').off();
                        $('.divJoin .divInput .input.text.id').css('display','block');
                        $('.divJoin .divInput').transition({
                          animate:'fade up',
                          duration:1500,
                          onComplete : function(){
                            $('.divJoin .divInput .input.text.id').focus();
                            addButtonEvent('id');
                          }
                        });
                      }
                    });
                  }
                }
              });
            }
          });
        }
      }
    });
  }
});

function addButtonEvent(type){
  if(type=='id'){
    $('.divJoin .divInput .input.button.id').click(function(){
      id = $('.divJoin .divInput .input.text.id').val();
      if(id == ""){
        $('.divJoin .divText .id.show').transition({
          animate:'fade up',
          duration:500,
          onComplete : function(){
            $('.divJoin .divText .id.show').html('입력칸이 비었네요</br>아이디를 입력해주세요');
            $('.divJoin .divText .id.show').transition({
              animate:'fade up',
              duration:500
            });
          }
        });
      }else if($('.divJoin .divInput .input.text.id').hasClass('duplicate')){
        $('.divJoin .divText .id.show').transition({
          animate:'fade up',
          duration:500,
          onComplete : function(){
            $('.divJoin .divText .id.show').html('사용할 수 없거나,</br>이미 다른분이 사용중이에요');
            $('.divJoin .divText .id.show').transition({
              animate:'fade up',
              duration:500
            });
          }
        });
      }
      else{
        var idCnt = 0;
        $('.divJoin .divText .id.show, .divJoin .divInput').transition({
          animate:'fade up',
          duration:500,
          interval  : 200,
          onComplete : function(){
            idCnt++;
            if(idCnt == 2){
              $('.divJoin .divText .static.id').text(id);
              var count = 00;
              $('.divJoin .divText .pw.hidden').transition({
                animation : 'fade up',
                duration  : 2000,
                interval  : 2500,
                onComplete : function(){
                  $(this).transition({
                    animation : 'fade up',
                    duration  : 500,
                    onComplete : function(){
                      count++;
                      if(count==1){
                        $('.divJoin .divText .pw.show').transition({
                          animate:'fade up',
                          duration:1500,
                          onComplete : function(){
                            $('.divJoin .divInput .input.text').val('');
                            $('.divJoin .divInput .input.text').attr('type','password');
                            $('.divJoin .divInput .input.text').addClass('pw');
                            $('.divJoin .divInput .input.text').removeClass('id');
                            $('.divJoin .divInput .input.button').addClass('pw');
                            $('.divJoin .divInput .input.button').removeClass('id');
                            $('.divJoin .divInput .input.button').css('display','inline-block');
                            $('.divJoin .divInput .input.button').off();
                            $('.divJoin .divInput .input.text.id').css('display','block');
                            $('.divJoin .divInput').transition({
                              animate:'fade up',
                              duration:1500,
                              onComplete : function(){
                                $('.divJoin .divInput .input.text.pw').focus();
                                addButtonEvent('pw');
                              }
                            });
                          }
                        });
                      }
                    }
                  });
                }
              });
            }
          }
        });
      }
    });
  }else if(type=="pw"){
    $('.divJoin .divInput .input.button.pw').click(function(){
      password = $('.divJoin .divInput .input.text.pw').val();
      if(password == ""){
        $('.divJoin .divText .pw.show').transition({
          animate:'fade up',
          duration:500,
          onComplete : function(){
            $('.divJoin .divText .pw.show').html('입력칸이 비었네요</br>비밀번호를 입력해주세요');
            $('.divJoin .divText .pw.show').transition({
              animate:'fade up',
              duration:500,
              onComplete : function(){
                $('.divJoin .divInput .input.text').focus();
              }
            });
          }
        });
      }else{
        $('.divJoin .divText .pw.show').transition({
          animate:'fade up',
          duration:500,
          onComplete : function(){
            $('.divJoin .divText .pw.show').html('한 번 더 입력해주세요');
            $('.divJoin .divText .pw.show').addClass('pwConf');
            $('.divJoin .divText .pw.show').removeClass('pw');
            $('.divJoin .divInput .text.pw').val('');
            $('.divJoin .divInput .pw').addClass('pwConf');
            $('.divJoin .divInput .pw').removeClass('inputID');
            $('.divJoin .divInput .pw').removeClass('pw');
            $('.divJoin .divText .pwConf.show').transition({
              animate:'fade up',
              duration:500,
              onComplete : function(){
                $('.divJoin .divInput .input.button').off();
                $('.divJoin .divInput .input.text').focus();
                addButtonEvent('pwConf');
              }
            });
          }
        });
      }
    });
  }else if(type="pwConf"){
    $('.divJoin .divInput .input.button.pwConf').click(function(){
      var pwConf = $('.divJoin .divInput .input.text.pwConf').val();
      if(password != pwConf){
        $('.divJoin .divText .pwConf.show').transition({
            animate:'fade up',
            duration:500,
            onComplete : function(){
              $('.divJoin .divText .pwConf.show').html('비밀번호가 다릅니다.<br>비밀번호를 다시 입력해주세요');
              $('.divJoin .divText .pwConf.show').addClass('pw');
              $('.divJoin .divText .pwConf.show').removeClass('pwConf');
              $('.divJoin .divInput .text.pwConf').val('');
              $('.divJoin .divInput .pwConf').addClass('pw');
              $('.divJoin .divInput .pwConf').removeClass('pwConf');
              $('.divJoin .divText .pw.show').transition({
                animate:'fade up',
                duration:500,
                onComplete : function(){
                  $('.divJoin .divInput .input.button').off();
                  addButtonEvent('pw');
                }
              });
            }
        });
      }else{
        var pwCount = 0;
        $('.divJoin .divText .pwConf.show, .divJoin .divInput').transition({
            animate:'fade up',
            duration:500,
            interval  : 200,
            onComplete : function(){
              pwCount++;
              if(pwCount==2){
                $('.divJoin .divText .tel.show').transition({
                    animate:'fade up',
                    duration:1000,
                    onComplete : function(){
                      $('.divJoin .divInput .text').css('display','none');
                      $('.divJoin .divInput .divTel').css('display','block');
                      $('.divJoin .divInput').transition({
                          animate:'fade up',
                          duration:1000,
                          onComplete : function(){
                            $('.divJoin .divInput .input.button').removeClass('pwConf');
                            $('.divJoin .divInput .input.button').addClass('tel');
                            $('.divJoin .divInput .input.button').off();
                            $('.divJoin .divInput .divTel .tel2').focus();
                            $('.divJoin .divInput .divTel .tel2').on("change keyup paste", function(e){
                              var str = $('.divJoin .divInput .divTel .tel2').val();
                              str = str.replace(/[^0-9]/g,'');
                              $('.divJoin .divInput .divTel .tel2').val(str);
                              if($(this).val().length >= 4){
                                $('.divJoin .divInput .divTel .tel3').focus();
                              }
                            });
                            $('.divJoin .divInput .divTel .tel3').on("change keyup paste", function(e){
                              var str = $('.divJoin .divInput .divTel .tel3').val();
                              str = str.replace(/[^0-9]/g,'');
                              $('.divJoin .divInput .divTel .tel3').val(str);
                            });
                            addLastEvent();
                          }
                      });
                    }
                });
              }
            }
        });
      }
    });
  }
}

function addLastEvent(){
  $('.divJoin .divInput .input.button.tel').click(function(){
    var inputTel1 = $('.divJoin .divInput .tel1').val();
    var inputTel2 = $('.divJoin .divInput .tel2').val();
    var inputTel3 = $('.divJoin .divInput .tel3').val();
    if(inputTel2.length < 3 || inputTel3.length < 3){
      $('.divJoin .divText .tel.show').transition({
          animate:'fade up',
          duration:500,
          onComplete : function(){
            $('.divJoin .divText .tel.show').html('전화번호가 맞지 않습니다.');
            $('.divJoin .divInput .tel2').val('');
            $('.divJoin .divInput .tel3').val('');
            $('.divJoin .divText .tel.show').transition({
              animate:'fade up',
              duration:500,
              onComplete : function(){
              }
            });
          }
      });
    }else{
      $.ajax({
            type:"POST",
            url:"/auth/ajaxJoinPrc",
            data : {
              id : id,
              pw : password,
              name : name,
              tel1:inputTel1,
              tel2:inputTel2,
              tel3:inputTel3
            },
            dataType : "json",
            success: function(res){
              console.log(res);
              location.href="/M_auth/joinResult";
            },
            error: function(xhr, status, error) {
              console.log(error);
              alert('회원가입 중 문제가 발생했습니다.\n계속 문제가 발생하면\n담당자에게 문의해주세요.');
              location.href="";
            }
        });
    }
  });
}

/***********************************************************
        아이디 변경 시 이벤트
***********************************************************/
var idReg = /^[a-z]+[a-z0-9]{5,19}$/g;
function addConfIDEvent(){
  $(".inputID").on("change keyup paste", function(e){
  var id = $(this).val();
  if(idReg.test(id)){
    idReg.test(id);
    $.ajax({
          type:"POST",
          url:"/auth/ajaxCheckID",
          data : {id : id},
          dataType : "json",
          success: function(res){
            console.log(res);
            if(res['duplicate']=='N'){
              $(e.target).removeClass('duplicate');
              $(e.target).addClass('non_duplicate');
              $('.is_duplicated').val(false);
            }else{
              $(e.target).removeClass('non_duplicate');
              $(e.target).addClass('duplicate');
              $('.is_duplicated').val(true);
            }
          },
          error: function(xhr, status, error) {
            console.log(error);
          }
      });
    }
    else{
      $(e.target).removeClass('non_duplicate');
      $(e.target).addClass('duplicate');
      $('.is_duplicated').val(true);
    }
  });
}

/***********************************************************
        일반사용자 가입버튼 클릭 시 이벤트
***********************************************************/
$('.divSection.joinNormal .joinBtn').click(function(e){
  if($('.inputID').val()==""){
    $('.errMsg').text("! 아이디를 입력해주세요.");
  }else if($('.inputPW1').val()=="" || $('.inputPW2').val()==""){
    $('.errMsg').text("! 비밀번호 입력해주세요.");
  }else if($('.inputPW1').val() != $('.inputPW2').val()){
    $('.errMsg').text("! 비밀번호를 확인해주세요.");
  }
  else if($('.inputNM').val()==""){
    $('.errMsg').text("! 이름을 입력해주세요.");
  }else if($('#tel1').val()=="" || $('#tel2').val()=="" || $('#tel3').val()==""){
    $('.errMsg').text("! 전화번호를 입력해주세요.");
  }else if($('.is_duplicated').val() == "true"){
    $('.errMsg').text("! 종복된 아이디로 사용이 불가합니다.");
  }else{
    $('.errMsg').text("");
    $('.joinFrm').submit();
  }
});

/***********************************************************
        사업자 가입버튼 클릭 시 이벤트
***********************************************************/
$('.divSection.joinBiz .joinBtn').click(function(e){
  if($('.inputID').val()==""){
    $('.errMsg').text("! 아이디를 입력해주세요.");
  }else if($('.inputPW1').val()=="" || $('.inputPW2').val()==""){
    $('.errMsg').text("! 비밀번호 입력해주세요.");
  }else if($('.inputPW1').val() != $('.inputPW2').val()){
    $('.errMsg').text("! 비밀번호를 확인해주세요.");
  }else if($('.inputBIZ_DV').val()==""){
    $('.errMsg').text("! 사업유형을 선택해주세요.");
  }else if($('.inputShopNM').val()==""){
    $('.errMsg').text("! 상호명을 입력해주세요.");
  }else if($('.inputPresentNM').val()==""){
    $('.errMsg').text("! 대표자명을 입력해주세요.");
  }else if($('.inputTel').val() == ""){
    $('.errMsg').text("! 전화번호를 입력해주세요.");
  }else if($('.inputBizNum').val() == ""){
    $('.errMsg').text("! 사업자번호를 입력해주세요.");
  }else if($('.inputBizNum').val().length < 10){
    $('.errMsg').text("! 사업자번호는 10자리입니다.");
  }else if(!reqBizNum($('.inputBizNum').val())){
    $('.errMsg').text("! 올바른 사업자번호가 아닙니다.");
  }else if($('.is_duplicated').val() == "true"){
    $('.errMsg').text("! 중복이나 사용할 수 없는 아이디입니다.");
  }else{
    $('.errMsg').text("");
    $('.joinFrm').submit();
  }
});

/***********************************************************
        사업자번호 값 변경 시
***********************************************************/
$('.inputBizNum').blur(function(e){
  reqBizNum($('.inputBizNum').val());
});

/***********************************************************
        사업자 가입버튼 클릭 시 이벤트
***********************************************************/
function reqBizNum(bizNum){
  if(bizNum.length < 10){
    return false;
  }
  var BizNumArr = new Array();
  for(var cnt=0; cnt<10; cnt++){
    BizNumArr[cnt] = bizNum.substring(cnt,cnt+1);
  }
  var step1 = BizNumArr[0]*1+BizNumArr[1]*3+BizNumArr[2]*7+BizNumArr[3]*1+BizNumArr[4]*3+BizNumArr[5]*7+BizNumArr[6]*1+BizNumArr[7]*3+BizNumArr[8]*5;
  var step2 = step1 + Math.floor(((step1%10)*BizNumArr[8])/10);
  var step3 = 10-step2%10;
  if(step3 == BizNumArr[9]){
    return true;
  }else{
    return false;
  }
}

/***********************************************************
        사업유형 클릭 시
***********************************************************/
$('.divSection .box input[type="button"].width3').click(function(e){
  $('.divSection .box input[type="button"].width3').removeClass('selected');
  $(this).addClass('selected');
  if($(this).val() == "농가"){
    $('.inputBIZ_DV').val('2');
  }else if($(this).val() == "도매"){
    $('.inputBIZ_DV').val('3');
  }else if($(this).val() == "소매"){
    $('.inputBIZ_DV').val('4');
  }
});

/***********************************************************
        아이디 찾기 버튼 클릭 이벤트
***********************************************************/
$('.findIDBtn').click(function(e){
  if($(this).hasClass('able')){
    var name = $('.inputFindNM').val();
    var tel1 = $('#sel_tel1').val();
    var tel2 = $('#tel2').val();
    var tel3 = $('#tel3').val();
    $.ajax({
          type:"POST",
          url:"/auth/ajaxFindID",
          data : {name:name, tel1:tel1, tel2:tel2, tel3:tel3 },
          dataType : "json",
          success: function(res){
            if(res['id']==null){
              $('.resultBox').html('<p>고객님의 정보와 일치하는 아이디가 없습니다.</p>');
            }else{
              console.log(res['id']);
              $('.resultBox').html('<p>고객님의 정보와 일치하는 아이디는</br><span>'+res['id']['USER_ID']+'</span> 입니다</p>');
            }
          },
          error: function(xhr, status, error) {
            console.log(error);
          }
      });
  }
});
/***********************************************************
        아이디 찾기 버튼 클릭 이벤트
***********************************************************/
var findID;
var timerRef;
var getIdentifyCode = false;
var findCount = 0;
var formVisible = false;
$('.getIdentifyCodeBtn').click(function(e){
  fn_IdentifyCode();
});
function fn_IdentifyCode(){
    var id = $('.inputFindID').val();
    var tel1 = $('#sel_tel1').val();
    var tel2 = $('#tel2').val();
    var tel3 = $('#tel3').val();
    if(id==""){
      alert('아이디를 입력해주세요.');
      return false;
    }else if(tel2==""||tel3==""){
      alert('전화번호를 입력해주세요.');
      return false;
    }else if(getIdentifyCode){
      alert('이미 인증번호를 전송했습니다.');
      return false;
    }else if(findCount>2){
      alert('인증번호 발송횟수를 초과하였습니다.');
      location.href = "/";
      return false;
    }
    $.ajax({
          type:"POST",
          url:"/auth/ajaxFindPW",
          data : {id:id, tel1:tel1, tel2:tel2, tel3:tel3 },
          dataType : "json",
          success: function(res){
            if(res['result']==true){
              if(!formVisible){
                $('.findID .identifyFrm').fadeIn('fast');
                $('.findID .pwResetBtn').fadeIn('fast');
                formVisible = true;
              }
              $('.resendBtn').off();
              getIdentifyCode = true;
              timerRef = setInterval('setTimer()',1000);
              console.log('set : '+timerRef);
              findCount = timerRef;
              $('.getIdentifyCodeBtn').addClass('disable');
              $('.inputIdentifyCode').focus();
              $('.frmID').val(id);
            }else{
              alert("입력한 정보와 일치하는 내용이 없습니다.\n다시 확인 부탁드립니다.");
            }
          },
          error: function(xhr, status, error) {
            console.log(error);
          }
      });
    }

var setTime = 180;
var min , sec = 0;
function setTimer(){
  setTime -= 1;
  min = lpad(String(Math.floor(setTime/60)),2,0);
  sec = lpad(String(setTime%60),2,0);
  $('.inputCount').val(min+":"+sec);
  if(setTime == 120){
    $('.getIdentifyCodeBtn').val('인증번호 재전송');
    $('.getIdentifyCodeBtn').removeClass('disable');
    $('.getIdentifyCodeBtn').addClass('resendBtn');
    $('.resendBtn').removeClass('disable');
    $('.getIdentifyCodeBtn').off();
    $('.getIdentifyCodeBtn').removeClass('getIdentifyCodeBtn');
    addResendEvent();
    getIdentifyCode = false;
  }
  if(setTime == 0){
    clearInterval(timerRef);
    alert('입력시간이 초과되었습니다.\n인증번호를 다시 받으세요.');
  }
}

function addResendEvent(){
  $('.resendBtn').click(function(e){
    console.log('재전송');
    var returnClear = clearInterval(timerRef);
    console.log("clear : "+returnClear);
    setTime = 180;
    $('.resendBtn').addClass('disable');
    $('.inputIdentifyCode').focus();
    fn_IdentifyCode();
  });
}

$('.pwResetBtn').click(function(e){
  var checkNum = $('.inputIdentifyCode').val();
  $.ajax({
        type:"POST",
        url:"/auth/checkRandomNum",
        data : {checkNum:checkNum},
        dataType : "json",
        success: function(res){
          if(res['result']==true){
            $('.resetFrm .frmCODE').val(checkNum);
            $('.resetFrm').submit();
          }else{
            alert("인증번호가 일치하지 않습니다.\n다시 확인 부탁드립니다.");
          }
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
    });
});

$('.resetPWBtn').click(function(e){
  console.log('aa');
  var pw1 = $('.inputPW1').val();
  var pw2 = $('.inputPW2').val();
  if(pw1==""||pw2==""){
    alert('비밀번호를 입력해주세요.');
    return false;
  }else if(pw1 != pw2){
    alert('비밀번호가 서로 다릅니다.\n다시 한 번 확인해주세요.');
    return false;
  }else{
    $('.resetFrm').submit();
  }
});
