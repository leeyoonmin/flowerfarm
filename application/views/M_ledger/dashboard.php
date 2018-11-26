<div class="wrap ledger dashboard" ondragstart="return false" onselectstart="return false">
  <div class="divLedgerControlBox">
    <table>
      <tr>
        <td>
          <a href="/ledger/daily"><img src="/static/img/icon/ic_calendar_day.png"></a>
        </td>
        <td>
          <a href="/ledger/month"><img src="/static/img/icon/ic_calendar_month.png"></a>
        </td>
        <td>
          <a href="/ledger/calendar"><img src="/static/img/icon/ic_calendar.png"></a>
        </td>
        <td>
          <a href="/ledger/dashboard"><img src="/static/img/icon/ic_chart_white4.png"></a>
        </td>
      </tr>
    </table>
    <table class="addLedger">
      <tr>
        <td>
          <a><img src="/static/img/icon/ic_plus_white.png"></a>
        </td>
        <td>
          가계부 작성
        </td>
      </tr>
    </table>
  </div>

  <div class="divLedgerLayout">
    <div class="divSearch">
      <table>
        <td>
          <a class="typeBtn plus selected">수입</a><a class="typeBtn minus">지출</a>
        </td>
        <td>
          <input class="calendarBtn prev" type="button" value="<<"><input type="text" class="calendarDate" value="<?php

          if($mode=="m"){
            echo $year.". ".$month;
          }else if($mode=="y"){
            echo $year;
          }

          ?>"><input class="calendarBtn next" type="button" value=">>">
        </td>
        <td>
          <select class="modeSelect">
            <option value="m" <?php if($mode=="m"){echo "selected";} ?>>월간</option>
            <option value="y" <?php if($mode=="y"){echo "selected";} ?>>년간</option>
          </select>
        </td>
      </table>
    </div>

    <?php
    $plusCount = 0;
    $minusCount = 0;
    $plusAmt = 0;
    $minusAmt = 0;
    foreach($chartData as $item){
      if($item->TYPE_CD == '01'){
        $plusCount++;
        $plusAmt = $plusAmt + $item->AMOUNT;
      }else if($item->TYPE_CD == '02'){
        $minusCount++;
        $minusAmt = $minusAmt + $item->AMOUNT;
      }
    }
    ?>

    <input type="hidden" class="CurrentType" value="plus">
    <div class="divChartLayout" style="font-size:16px;">
      <?php

        if($plusCount>0){
          echo "<div class=\"divChart chartPlus\" id=\"chart_plus\"></div>";
        }else{
          echo "<div class=\"divChart chartPlus emptyChart\">수입내역이 없습니다.</div>";
        }
        if($minusCount>0){
          echo "<div class=\"divChart chartMinus\" id=\"chart_minus\"></div>";
        }else{
          echo "<div class=\"divChart  chartMinus emptyChart\">지출내역이 없습니다.</div>";
        }


          echo "
            <div class=\"divGrid gridPlus\">
              <table>";
              foreach($chartData as $item){
                if($item->TYPE_CD == '01'){
                  echo "<tr type=\"".$item->TYPE_CD."\" cate=\"".$item->CATE_CD."\">
                    <td><span>".round($item->AMOUNT/$plusAmt*100,1)."%</span></td>
                    <td>".($item->CATE)."</td>
                    <td>".number_format($item->AMOUNT)." 원</td>
                  </tr>";
                }
              }
        echo "</table>
            </div>
          ";

          echo "
            <div class=\"divGrid gridMinus\">
              <table>";
              foreach($chartData as $item){
                if($item->TYPE_CD == '02'){
                  echo "<tr type=\"".$item->TYPE_CD."\" cate=\"".$item->CATE_CD."\">
                  <td><span>".round($item->AMOUNT/$plusAmt*100,1)."%</span></td>
                  <td>".($item->CATE)."</td>
                  <td>".number_format($item->AMOUNT)." 원</td>
                  </tr>";
                }
              }
        echo "</table>
            </div>
          ";

      ?>
    </div>

  </div>



</div>
<pre id="tsv" style="display:none">Browser Version  Total Market Share
Microsoft Internet Explorer 8.0  26.61%
Microsoft Internet Explorer 9.0  16.96%
Chrome 18.0  8.01%
Chrome 19.0  7.73%
Firefox 12  6.72%
Microsoft Internet Explorer 6.0  6.40%
Firefox 11  4.72%
Microsoft Internet Explorer 7.0  3.55%
Safari 5.1  3.53%
Firefox 13  2.16%
Firefox 3.6  1.87%
Opera 11.x  1.30%
Chrome 17.0  1.13%
Firefox 10  0.90%
Safari 5.0  0.85%
Firefox 9.0  0.65%
Firefox 8.0  0.55%
Firefox 4.0  0.50%
Chrome 16.0  0.45%
Firefox 3.0  0.36%
Firefox 3.5  0.36%
Firefox 6.0  0.32%
Firefox 5.0  0.31%
Firefox 7.0  0.29%
Proprietary or Undetectable  0.29%
Chrome 18.0 - Maxthon Edition  0.26%
Chrome 14.0  0.25%
Chrome 20.0  0.24%
Chrome 15.0  0.18%
Chrome 12.0  0.16%
Opera 12.x  0.15%
Safari 4.0  0.14%
Chrome 13.0  0.13%
Safari 4.1  0.12%
Chrome 11.0  0.10%
Firefox 14  0.10%
Firefox 2.0  0.09%
Chrome 10.0  0.09%
Opera 10.x  0.09%
Microsoft Internet Explorer 8.0 - Tencent Traveler Edition  0.09%</pre>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script>
var colorPlus = (function () {
  var colors = [],
    base = '#00a3ff';
  for (i = 0; i < 10; i += 1) {
    colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
  }
  return colors;
}());

var colorMinus = (function () {
  var colors = [],
    base = '#ff3d00';
  for (i = 0; i < 10; i += 1) {
    colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
  }
  return colors;
}());

Highcharts.chart('chart_plus', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    style:{display:'none'}
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.y}원</b>'
  },
  plotOptions: {
    pie: {
            allowPointSelect: true,
            colors:colorPlus,
            cursor: 'pointer',
            dataLabels: {
                <?php
                $mobilechk = '/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/i';
                if(preg_match($mobilechk, $_SERVER['HTTP_USER_AGENT'])){
                  echo "
                    enabled: true,
                    format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                    distance: -50,
                    filter: {
                      property: 'percentage',
                      operator: '>',
                      value: 4
                    }
                  ";
                }else{
                  echo "
                  enabled: true,
                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                  style: {
                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                      fontSize:'14px'
                  },
                  connectorColor: '#00a3ff'";
                }

                ?>
            }
        }
  },
  series: [{
    name: '비용',
    data: [
      <?php
        foreach($chartData as $item){
          if($item->TYPE_CD == "01"){
            echo "{ name: '".$item->CATE."', y: ".$item->AMOUNT." },";
          }
        }
      ?>
    ]
  }]
});

Highcharts.chart('chart_minus', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    style:{display:'none'}
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.y}원</b>'
  },
  plotOptions: {
    pie: {
            allowPointSelect: true,
            colors:colorMinus,
            cursor: 'pointer',
            dataLabels: {
              <?php
              $mobilechk = '/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/i';
              if(preg_match($mobilechk, $_SERVER['HTTP_USER_AGENT'])){
                echo "
                  enabled: true,
                  format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                  distance: -50,
                  filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                  }
                ";
              }else{
                echo "
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                    fontSize:'14px'
                },
                connectorColor: '#00a3ff'";
              }

              ?>
            }
        }
  },
  series: [{
    name: '비용',
    data: [
      <?php
        foreach($chartData as $item){
          if($item->TYPE_CD == "02"){
            echo "{ name: '".$item->CATE."', y: ".$item->AMOUNT." },";
          }
        }
      ?>
    ]
  }]
});
</script>
