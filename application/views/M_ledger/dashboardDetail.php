<div class="wrap ledger dashboard detail" ondragstart="return false" onselectstart="return false">
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
        </td>
        <td>
          <input class="modeSelect" type="hidden" value="y">
          <input class="TYPE_HD" type="hidden" value="<?=$type?>">
          <input class="CATE_HD" type="hidden" value="<?=$cate?>">
          <input class="calendarBtn prev" type="button" value="<<"><input type="text" class="calendarDate" value="<?php

            echo $year."년";

          ?>"><input class="calendarBtn next" type="button" value=">>">
        </td>
        <td>
        </td>
      </table>
    </div>
    <div class="divChartLayout" style="font-size:16px;">
      <div id="chart1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
      <?php
      echo "
        <div class=\"divGrid2 gridPlus\">
          <table><tr>";
          for($c=1;$c<13;$c++){
            $is_month = false;
            foreach($chartData as $item){
              if(str_pad($c,2,0,STR_PAD_LEFT)==$item->MONTH){
                echo "
                  <td year=\"".$year."\" month=\"".$c."\">".$c."월</td>
                  <td year=\"".$year."\" month=\"".$c."\">".number_format($item->AMOUNT)." 원</td>
                  ";
                $is_month = true;
              }
            }
            if($is_month == false){
              echo "
                <td year=\"".$year."\" month=\"".$c."\">".$c."월</td>
                <td year=\"".$year."\" month=\"".$c."\">0 원</td>
                ";
            }
            if($c%2==0){
              echo "</tr><tr>";
            }
          }
          echo "</tr></table>
          </div>";
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
<script type="text/javascript">
Highcharts.chart('chart1', {
  chart: {
    type: 'line'
  },
  colors: ['#FE8200', '#f7a35c', '#90ee7e', '#7798BF', '#aaeeee', '#ff0066',
        '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
  title: {
    text: 'Monthly Average Temperature',
    style:{display:'none'}
  },
  subtitle: {
    text: 'Source: WorldClimate.com',
    style:{display:'none'}
  },
  xAxis: {
    categories: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월']
  },
  yAxis: {
    title: {
      text: '금액(원)'
    }
  },
  plotOptions: {
        series: {
            cursor: 'pointer',
            point: {
                events: {
                    click: function (e) {
                        hs.htmlExpand(null, {
                            pageOrigin: {
                                x: e.pageX || e.clientX,
                                y: e.pageY || e.clientY
                            },
                            headingText: this.series.name,
                            maincontentText: Highcharts.dateFormat('%A, %b %e, %Y', this.x) + ':<br/> ' +
                                this.y + ' sessions',
                            width: 200
                        });
                    }
                }
            },
            marker: {
                lineWidth: 1
            }
        }
    },
  tooltip: {
        shared: true,
        crosshairs: true
    },
  series: [{
    name: '<?php if(empty($chartData)){echo $catenm;}else{echo $chartData[0]->CATE;}?>',
    data: [
      <?php

      for($c=1;$c<13;$c++){
        $is_month = false;
        foreach($chartData as $item){
          if(str_pad($c,2,0,STR_PAD_LEFT)==$item->MONTH){
            echo $item->AMOUNT.",";
            $is_month = true;
          }
        }
        if($is_month == false){
          echo "0,";
        }
      }

      ?>
    ]
  }]
});
</script>
