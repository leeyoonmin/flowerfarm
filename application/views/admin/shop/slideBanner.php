<div class="wrap slideBanner">

  <div class="divPageTitle">
    <table>
      <tr>
        <td class="engTitle">Slide Banner Mananger</td><td class="hanTitle">슬라이드 베너 관리</td><td></td>
      </tr>
    </table>
  </div>

  <div class="divButton">
    <input class="selected desktop" type="button" value="데스크탑"><input class="mobile" type="button" value="모바일">　* 데스크탑 : 1920*370　/　모바일 : 360*360
  </div>

  <div class="divGrid">
    <table class="desktop">
      <?php
        $rowCnt = 0;
        foreach($gridData1 as $item){$rowCnt++;}
        $count = 0;
        foreach($gridData1 as $item){
          echo "<tr>
            <td><img src=\"/static/img/slide/".$item->CODE."\"></td>
            <td>
              <input type=\"hidden\" value=\"".$item->IDXKEY."\">
              <input class=\"btn modify blue\" type=\"button\" value=\"수정\"><br><br>
              <input class=\"btn delete red\" type=\"button\" value=\"삭제\">
            </td>
            ";
              if($count==0){
                echo "<td rowspan=\"".$rowCnt."\"><img class=\"add\" src=\"/static/img/icon/ic_plus_white.png\"></td>";
              }
            "</tr>";
            $count++;
        }
      ?>
    </table>
    <table class="mobile">
      <?php
        $rowCnt = 0;
        foreach($gridData2 as $item){$rowCnt++;}
        $count = 0;
        foreach($gridData2 as $item){
          echo "<tr>
            <td><img src=\"/static/img/slide/".$item->CODE."\"></td>
            <td>
              <input type=\"hidden\" value=\"".$item->IDXKEY."\">
              <input class=\"btn blue modify\" type=\"button\" value=\"수정\"><br><br>
              <input class=\"btn red delete\" type=\"button\" value=\"삭제\">
            </td>
            ";
              if($count==0){
                echo "<td rowspan=\"".$rowCnt."\"><img class=\"add\" src=\"/static/img/icon/ic_plus_white.png\"></td>";
              }
            "</tr>";
            $count++;
        }
      ?>
    </table>
  </div>
</div>

<div class="divImageViewer">
  <form enctype="multipart/form-data" action="/admin/slideBannerUpdate" method="post">
    <div class="divImage">
      <img id="output"/>
    </div>
    <div class="divUpdateButton">
      <table>
        <tr>
          <td>
            <input type="file" accept="image/*" name="PRD_IMG" onchange="loadFile(event)">
          </td>
          <td>
            <input class="formMode" type="hidden" name="mode" value="">
            <input class="formType" type="hidden" name="type" value="pc">
            <input class="formID" type="hidden" name="id" value="">
            <input type="submit" value="업로드">
          </td>
        </tr>
      </table>
    </div>
  </form>
</div>
<div class="divImageViewerBG"></div>
