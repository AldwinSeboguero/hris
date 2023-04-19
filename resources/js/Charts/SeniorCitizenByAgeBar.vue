<template>
<div class="ma-0 pb-0">
<apexchart type="bar" height="450" :options="chartOptions1" :series="series"></apexchart>
</div>
</template>

<script>
import { defineComponent } from '@vue/composition-api'


export default defineComponent({
    props:{
        datas_male: Array,
        datas_female: Array,

    },
    mounted(){
      this.chartOptions1 ={
        chart: {
          height: 450,
          type: 'bar',
        },
        plotOptions: {
          bar: {
            borderRadius: 5,
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        dataLabels: {
          enabled: true,
          formatter: function (val) {
            return val;
          },
          offsetY: -20, 
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        
        xaxis: {
          categories: ['60', '61', '62', '63', '64', '65', '66', '67', '68', '69',
              '70', '71', '72', '73', '74', '75', '76', '77', '78', '79',
              '80', '81', '82', '83', '84', '85', '86', '87', '88', '89',
              '90', '91', '92', '93', '94', '95', '96', '97', '98', '99',
              '100','>100'
              ],
          position: 'bottom',
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false
          },
          crosshairs: {
            fill: {
              type: 'gradient',
              gradient: {
                colorFrom: '#D8E3F0',
                colorTo: '#BED1E6',
                stops: [0, 100],
                opacityFrom: 0.4,
                opacityTo: 0.5,
              }
            }
          },
          tooltip: {
            enabled: true,
          }
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
            formatter: function (val) {
              return val;
            }
          }
        
        },
        title: {
          text: '',
          floating: true,
          offsetY: 330,
          align: 'center',
          style: {
            color: '#444'
          }
        }
        
      };

      // };
      // this.chartOptions = {
      //       chart: {
      //         type: 'bar',
      //         height: 410,
      //         width: '100%',
      //         stacked: true,
      //         toolbar: {
      //           show: true
      //         },  
      //         zoom: {
      //           enabled: true
      //         }
      //       },
      //       responsive: [{
      //         breakpoint: 480,
      //         options: {
      //           legend: {
      //             position: 'bottom',
      //             offsetX: -10,
      //             offsetY: 0
      //           }
      //         }
      //       }],
      //       plotOptions: {
      //         bar: {
      //           colors: {
      //             ranges: [{
      //               from: -100,
      //               to: -46,
      //               color: '#F15B46'
      //             }, {
      //               from: -45,
      //               to: 0,
      //               color: '#FEB019'
      //             }]
      //           },
                
      //           horizontal: false,
      //           borderRadius: 5,
      //           dataLabels: {
      //             show: false,
      //             // total: {
      //             //   enabled: false,
      //             //   style: {
      //             //     fontSize: '13px',
      //             //     fontWeight: 900
      //             //   }
      //             // }
      //           },
      //           legends:{
      //             enabled:false,
      //           }
      //         },
      //       },
      //       xaxis: {
      //         type: 'text',
      //         categories: ['60', '61', '62', '63', '64', '65', '66', '67', '68', '69',
      //         '70', '71', '72', '73', '74', '75', '76', '77', '78', '79',
      //         '80', '81', '82', '83', '84', '85', '86', '87', '88', '89',
      //         '90', '91', '92', '93', '94', '95', '96', '97', '98', '99',
      //         '100','>100'
      //         ],
      //       },
      //       legend: {
      //         position: 'bottom',
      //         offsetX: 40,
      //         offsetY: 10,
      //       },
      //       fill: {
      //         opacity: 1
      //       }
      //     };
    },
    data: function() {
    return {
   series: [{
            name: 'Senior',
            data: this.datas_male,
          } 
          // {
          //   name: 'Female',
          //   data: this.datas_female
          // }, 
        ],
          chartOptions: {
          },
          chartOptions1: {
          },
    }
  },
    setup() {
        
    },
})
</script>
