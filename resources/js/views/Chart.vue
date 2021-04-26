<template>
  <b-container class="small">
    <b-row class="text-center">
      <b-col>
        <p>{{this.probe_type}} to {{this.resource_name}} from {{this.host_ip}}</p>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <line-chart :chart-data="datacollection" :options="chart_options"></line-chart>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import LineChart from './LineChart.js'
import * as graph_helper from '../helpers/graph.js'

export default {
  components: {
    'line-chart' : LineChart
  },
  props: {
    host_ip: String,
    probe_type: String,
    resource_name: String,
    time: String,
    field: String,
  },
  data: function() {
    return {
      datacollection: null,
      chart_options: {
        responsive: true,
        maintainAspectRatio: false
      },
    }
  },
  methods: {
      GetData: function() {
        graph_helper.getGraph({
          params: {
            from_host: this.host_ip,
            resource_name: this.resource_name,
            probe_type: this.probe_type,
            time: this.time,
            field: this.field
          },
          then: response => {
                this.datacollection = response.data
            }
        })
          // axios
          //   .get("http://192.168.6.149/api/graph/get" + 
          //        "?from_host="     + this.host_ip + 
          //        "&resource_name=" + this.resource_name + 
          //        "&probe_type="    + this.probe_type +
          //        "&time="          + this.time +
          //        "&field="         + this.field)
          //   .then(response => {
          //       this.datacollection = response.data
          //   })
      }
  },
  mounted() {
      this.GetData()
      console.log(this.host_ip);
  }
}
</script>

<style>
  .small {
    max-width: 95%;
    max-height: 50%;
    margin:  0px auto;
  }

  .small p {
    font-size: 20px;
  }
</style>