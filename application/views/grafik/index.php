

<script src="https://layanan-ksp.go.id/kepegawaian/src/Chart.min.js"></script>
<script src="https://layanan-ksp.go.id/kepegawaian/src/Chart.PieceLabel.js"></script>
<div class="row">
	<div class="col-6">
		<div class="card">
			<div class="card-header">Donat</div>
			<div class="card-body">
				<canvas id="pieChart" style="height:250px"></canvas>
				<script type="text/javascript">
				  $(function () {

				      // new Chart(document.getElementById("pieChart"), {
				      new Chart($("#pieChart"), {
				          type: 'doughnut',
				          data: {
				            labels: ["Tenaga Ahli Utama", "Tenaga Ahli Madya", "Tenaga Ahli Muda", "Tenaga Terampil", ],
				            datasets: [
				              {
				                backgroundColor: ["red", "blue", "green", "orange",],
				                data: ["2", "14", "8", "1", ]
				              }
				            ]
				          },
				          options: {
				            legend: {
				              display: true,
				              position: 'left',
				            },
				            title: {
				              display: true,
				              text: 'Slot Pegawai Tersedia',
				              position: 'bottom',
				            },
				            pieceLabel: {
				              mode: 'value'
				            },
				            elements: {
				              center: {
				                text: '25',
				                color: 'black', // Default is #000000
				                fontStyle: 'Arial', // Default is Arial
				                sidePadding: 20 // Defualt is 20 (as a percentage)
				              }
				            }
				          },
				      });
				  });

				  Chart.pluginService.register({
				    beforeDraw: function (chart) {
				      if (chart.config.options.elements.center) {
				        //Get ctx from string
				        var ctx = chart.chart.ctx;
				        
				        //Get options from the center object in options
				        var centerConfig = chart.config.options.elements.center;
				        var fontStyle = centerConfig.fontStyle || 'Arial';
				        var txt = centerConfig.text;
				        var color = centerConfig.color || '#000';
				        var sidePadding = centerConfig.sidePadding || 20;
				        var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
				        //Start with a base font of 30px
				        ctx.font = "30px " + fontStyle;
				        
				        //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
				        var stringWidth = ctx.measureText(txt).width;
				        var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

				        // Find out how much the font can grow in width.
				        var widthRatio = elementWidth / stringWidth;
				        var newFontSize = Math.floor(30 * widthRatio);
				        var elementHeight = (chart.innerRadius * 2);

				        // Pick a new font size so it will not be larger than the height of label.
				        var fontSizeToUse = Math.min(newFontSize, elementHeight);

				        //Set font settings to draw it correctly.
				        ctx.textAlign = 'center';
				        ctx.textBaseline = 'middle';
				        var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
				        var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
				        ctx.font = fontSizeToUse+"px " + fontStyle;
				        ctx.fillStyle = color;
				        
				        //Draw text in center
				        ctx.fillText(txt, centerX, centerY);
				      }
				    }
				  });
				</script>
			</div>
		</div>
	</div>


	<div class="col-6">
		<div class="card">
			<div class="card-header">Bar</div>
			<div class="card-body">
				<canvas id="barChart1" style="height:250px"></canvas>
				<script type="text/javascript">
				  $(function () {

				      new Chart(document.getElementById("barChart1"), {
				          type: 'bar',
				          data: {
				            labels: ["Kedeputian I", "Kedeputian II", "Kedeputian III", "Kedeputian IV", "Kedeputian V", ],
				            datasets: [
				                            {
				                label: "Tenaga Ahli Utama",
				                backgroundColor: "#f56954",
				                data: [3, 4, 4, 3, 5, ]
				              },
				                            {
				                label: "Tenaga Ahli Madya",
				                backgroundColor: "#3c8dbc",
				                data: [7, 5, 3, 8, 4, ]
				              },
				                            {
				                label: "Tenaga Ahli Muda",
				                backgroundColor: "#00a65a",
				                data: [7, 12, 3, 4, 4, ]
				              },
				                            {
				                label: "Tenaga Terampil",
				                backgroundColor: "#f39c12",
				                data: [9, 7, 4, 6, 3, ]
				              },
				                          ]
				          },
				          options: {
				            legend:{
				              display: true,
				              position: 'right',
				            },
				            title: {
				              display: true,
				              text: 'Rekap Pegawai',
				              position: 'bottom',
				            },
				            scales: {
				              yAxes: [{
				                ticks: {
				                  min:0,
				                  steps: 2,
				                  max: 17,
				                },
				              }],
				            }
				          },
				      });

				  });
				</script>
			</div>
		</div>
	</div>



	<div class="col-6" style="margin-top: 10px">
		<div class="card">
			<div class="card-header">Line</div>
			<div class="card-body">
				<canvas id="lineChart1" style="height: 250px"></canvas>
				<script type="text/javascript">
				  $(document).ready(function() {
				    //Run method
				    poll();
				    //Run Method
				  });

				  function poll() {
			    	data = [{"outanggal":"02","outanggal_pros":"02","bln_thn":"2017-01"},{"outanggal":"01","outanggal_pros":"01","bln_thn":"2017-02"},{"outanggal":"01","outanggal_pros":"01","bln_thn":"2017-03"},{"outanggal":"04","outanggal_pros":"03","bln_thn":"2017-04"},{"outanggal":"01","outanggal_pros":"01","bln_thn":"2017-05"},{"outanggal":"08","outanggal_pros":"08","bln_thn":"2017-06"},{"outanggal":"03","outanggal_pros":"01","bln_thn":"2017-07"},{"outanggal":"03","outanggal_pros":"03","bln_thn":"2017-08"},{"outanggal":"02","outanggal_pros":"02","bln_thn":"2017-09"},{"outanggal":"03","outanggal_pros":"02","bln_thn":"2017-10"},{"outanggal":"01","outanggal_pros":"01","bln_thn":"2017-11"},{"outanggal":"10","outanggal_pros":"04","bln_thn":"2017-12"}];
			        console.log(data);
			        var score = [];
			        var score2 = [];
			        var months = [];
			        for (var i in data) {
			          score.push(data[i].outanggal);
			          score2.push(data[i].outanggal_pros);
			        }
			        // alert(score);
			        new Chart(document.getElementById("lineChart1"), {
			          type: 'line',
			          data: {
			            labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "Desember"],
			            datasets: [{ 
			                data: score,
			                label: "Terbit",
			                // borderColor: "green",
			                // backgroundColor: "red",
			                borderColor: "blue",
			                backgroundColor: "green",
			                fill: false,
			                scaleOverride: true,
			                scaleStepWidth: 1,
			                scaleSteps: 10,
			                scaleStartValue: 5,
			                pointRadius:10,
			                pointHitRadius:10,
			              },
			              {
			                data: score2,
			                label: "Mulai Proses",
			                borderColor: "red",
			                backgroundColor: "orange",
			                fill: false,
			                scaleOverride: true,
			                scaleStepWidth: 1,
			                scaleSteps: 10,
			                scaleStartValue: 5,
			                pointRadius:10,
			                pointHitRadius:10,
			              }
			            ]
			          },
			          options: {
			            legend:{
			              display: true,
			              position: 'left',
			            },
			            scales: {
			              yAxes: [{
			                display: true,
			                ticks: {
			                  min: 0,
			                  steps: 1,
			                  max: 10,
			                }
			              }]
			            },
			            title: {
			              display: true,
			              text: 'Proses Perbulan',
			              position: 'bottom',
			            },
			            responsive: true, 
			            maintainAspectRatio: false,
			          }
			        });
				  }
				</script>
			</div>
		</div>
	</div>



	<div class="col-6" style="margin-top: 10px">
		<div class="card">
			<div class="card-header">Pie</div>
			<div class="card-body">
				<canvas id="pieChart2" style="height: 250px"></canvas>
				<script type="text/javascript">
					var color = Chart.helpers.color;
					$(function(){
						new Chart(document.getElementById("pieChart2"), {
					        type: 'pie',
					        data: {
					            datasets: [{
					                data: [9,3,25],
					                backgroundColor: [
					                    color('red').alpha(0.5).rgbString(),
					                    color('green').alpha(0.5).rgbString(),
					                    color('blue').alpha(0.5).rgbString(),
					                ],
					                label: 'Status Rapat'
					            }],
					            labels: [
					                "Belum",
					                "Berlangsung",
					                "Selesai",
					            ]
					        },
					        options: {
					            responsive: true,
			            		maintainAspectRatio: false,
					            title: {
					              display: true,
					              text: 'Status Kegiatan',
					              position: 'bottom'
					            },
					            legend:{
					              display: true,
					              position: 'right',
					            },
					        }
					    });

					});
				</script>
			</div>
		</div>
	</div>



	<div class="col-6" style="margin-top: 10px">
		<div class="card">
			<div class="card-header">Pie</div>
			<div class="card-body">
				<canvas id="pieChart3" style="height: 250px"></canvas>
				<script type="text/javascript">
					// $(function(){
					// 	drawSegmentValues();
					// })

					var data = [
					    {
					        value: 100,
					        color:"#F7464A",
					        highlight: "#FF5A5E",
					        label: "Red"
					    },
					    {
					        value: 50,
					        color: "#46BFBD",
					        highlight: "#5AD3D1",
					        label: "Green"
					    },
					    {
					        value: 25,
					        color: "#FDB45C",
					        highlight: "#FFC870",
					        label: "Yellow"
					    },
					    {
					        value: 25,
					        color: "green",
					        highlight: "#FFC870",
					        label: "Yellow"
					    },    
					];

					var canvas = document.getElementById("pieChart3");
					var ctx = canvas.getContext("2d");
					var midX = canvas.width/2;
					var midY = canvas.height/2
					var totalValue = getTotalValue(data);

					// Create a pie chart
					var myPieChart = new Chart(ctx).Pie(data, {
					    showTooltips: false,
					    onAnimationProgress: drawSegmentValues
					});

					var radius = myPieChart.outerRadius;

					function drawSegmentValues()
					{
					    for(var i=0; i<myPieChart.segments.length; i++) 
					    {
					        ctx.fillStyle="white";
					        var textSize = canvas.width/15;
					        ctx.font= textSize+"px Verdana";
					        // Get needed variables
					        var value = myPieChart.segments[i].value/totalValue*100;
					        if(Math.round(value) !== value)
					        	value = (myPieChart.segments[i].value/totalValue*100).toFixed(1);
					        value = value + '%';
					        
					        var startAngle = myPieChart.segments[i].startAngle;
					        var endAngle = myPieChart.segments[i].endAngle;
					        var middleAngle = startAngle + ((endAngle - startAngle)/2);

					        // Compute text location
					        var posX = (radius/2) * Math.cos(middleAngle) + midX;
					        var posY = (radius/2) * Math.sin(middleAngle) + midY;

					        // Text offside by middle
					        var w_offset = ctx.measureText(value).width/2;
					        var h_offset = textSize/4;

					        ctx.fillText(value, posX - w_offset, posY + h_offset);
					    }
					}

					function getTotalValue(arr) {
					    var total = 0;
					    for(var i=0; i<arr.length; i++)
					        total += arr[i].value;
					    return total;
					}
				</script>
			</div>
		</div>
	</div>



	<div class="col-6" style="margin-top: 10px">
		<div class="card">
			<div class="card-header">Bar</div>
			<div class="card-body">
				<canvas id="barChar2" style="height:250px"></canvas>
				<style type="text/css">
					.graph_container{
					  /*display:block;*/
					  /*width:1000px;*/
					  /*height: 390px;*/
					}
				</style>
				<script type="text/javascript">
					var barOptions_stacked = {
				        // responsive: true,
					    tooltips: {
					        enabled: true
					    },
					    hover :{
					        animationDuration:0
					    },
					    scales: {
					        xAxes: [{
					            ticks: {
					                beginAtZero:true,
					                fontFamily: "'Open Sans Bold', sans-serif",
					                fontSize:14
					            },
					            scaleLabel:{
					                display:false
					            },
					            gridLines: {
					            }, 
					            stacked: true
					        }],
					        yAxes: [{
					            gridLines: {
					                display:false,
					                color: "#fff",
					                zeroLineColor: "#fff",
					                zeroLineWidth: 0
					            },
					            ticks: {
					                fontFamily: "'Open Sans Bold', sans-serif",
					                fontSize:14
					            },
					            stacked: true
					        }]
					    },
					    legend:{
					        display:true,
				            position: 'right',
					    },
				        title: {
				          display: true,
				          text: 'Pelaksanaan Tindak Lanjut',
				          position: 'bottom',
				        },
					    
					    animation: {
					        onComplete: function () {
					            var chartInstance = this.chart;
					            var ctx = chartInstance.ctx;
					            ctx.textAlign = "left";
					            ctx.font = "9px Open Sans";
					            ctx.fillStyle = "#000000";
					            /*
					            Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
					                var meta = chartInstance.controller.getDatasetMeta(i);
					                Chart.helpers.each(meta.data.forEach(function (bar, index) {
					                    data = dataset.data[index];
					                    if(i==0){
					                        ctx.fillText(data, 251, bar._model.y+4);
					                    } else {
					                        ctx.fillText(data, bar._model.x-25, bar._model.y+4);
					                    }
					                }),this)
					            }),this);
					            */
					        }
					    },
					    pointLabelFontFamily : "Quadon Extra Bold",
					    scaleFontFamily : "Quadon Extra Bold",
					    // fontSize: 14,
			            responsive: true,
	            		maintainAspectRatio: false,
					};

					var ctx = document.getElementById("barChar2");
					var myChart = new Chart(ctx, {
					    type: 'horizontalBar',
					    data: {
					        labels: ["Kepala","Deputi I","Deputi II","Deputi III","Deputi IV","Deputi V"],					        
					        datasets: [{
					            data: [3,2,5,1,3,7],
					            backgroundColor: "grey",
					            hoverBackgroundColor: "#D3D3D3",
					            label: "Assigned"
					        },{
					            data: [2,5,3,3,1,7],
					            backgroundColor: "green",
					            hoverBackgroundColor: "#C8FECA",
					            label: "On Progress"
					        },{
					            data: [5,3,1,3,2,7],
					            backgroundColor: "blue",
					            hoverBackgroundColor: "#C8D5FE",
					            label: "Finished"
					        },{
					            data: [3,2,7,5,1,3],
					            backgroundColor: "red",
					            hoverBackgroundColor: "#FEC8CD",
					            label: "Overdue"
					        }]
					    },

					    options: barOptions_stacked,
					});
				</script>
			</div>
		</div>
	</div>



</div>