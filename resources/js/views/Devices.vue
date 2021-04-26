<template>
  <b-container fluid>
      <b-row>
        <b-col>
          <b-button variant="outline-primary" id="show-modal" @click="ShowAddDialog">➕</b-button>
          <add-host v-if="showModal" 
              v-bind:probes="probes_to_show" 
              v-bind:old_data="old_data"
              v-bind:old_available_probes="old_available_probes"
              @close="CloseAddDialog">
          </add-host>
        </b-col>
      </b-row>
      
      <b-table :items="devices" :fields="device_table.fields">
        <template #table-colgroup="scope">
            <col
            v-for="field in scope.fields"
            :key="field.key"
            :style="{ width: field.key === 'delete' ? '20%' : '20%' }"
            >
        </template>

        <template #head(delete)="row">
            {{row.field["label"]}}
        </template>
        
        <template #cell(name)="row">
            {{row.item.name}}
        </template>

        <template #cell(ip)="row">
            <p>{{row.item.ip}}</p>
        </template>

        <template #cell(notes)="row">
            <p>{{row.item.notes}}</p>
        </template>

        <template #cell(available_probes)="row">
          <p v-for="(probe, number) in probe_assignation_dict[row.item.id]" :key="number"> {{probes[probe]}} </p>
        </template>

        <template #cell(created_at)="row">
          <p>{{row.item.created_at}}</p>
        </template>

        <template #cell(actions)="row">
            <div class="close-button-wrapper">
                <b-button class="close" @click="UpdateItem(row)">🖉</b-button>
                <b-button-close @click="DeleteItem(row)"></b-button-close>
            </div>
        </template>
      </b-table>

  </b-container>
</template>
<script>
// import axios from 'axios'
import * as device_helper from '../helpers/devices.js'
import * as probe_helper from '../helpers/probes.js'

// import AddHost from './CustomAddModalWindow.vue'
import AddHost from './AddHost.vue'

  export default {
    components: {
        'add-host': AddHost
    },
    data: function() {
      return {
        devices : [],

        old_available_probes: {},
        probe_assignation_dict: {},
        probe_assignation: [],
        probes_to_show: [],

        probes: [],
        base_probes_list: {},
        base_probes: [],
        device_table: {
            fields: [{
                        'key': 'name',
                        'label': 'Название'
                    }, 
                    {
                        'key': 'ip',
                        'label': 'IP'
                    }, 
                    {
                        'key': 'notes',
                        'label': 'Заметки'
                    }, 
                    {
                        'key': 'created_at',
                        'label': 'Создано'
                    },
                    {
                        'key': 'available_probes',
                        'label': 'Доступные метрики'
                    },
                    {   
                        'key': 'actions',
                        'label': 'Действия'
                    }]
        },
        old_data: null,
        showModal: false
      }
    },
    methods:
    {
      ShowAddDialog: function(event) {
          this.old_data = null
          this.old_available_probes = null

          this.showModal = true
      },
      CloseAddDialog: function(event) {
          this.GetProbes()
          this.GetDevices()
          this.GetProbeAssignation()

          this.showModal = false
      },
      GetBaseProbes: function() {
          probe_helper.getBaseProbes({
            then: response => {
                    this.base_probes = response.data

                    this.base_probes_list = {}
                    this.base_probes.forEach((item) => {
                        this.base_probes_list[item.id] = item.name
                    })
                  }
          })
      },
      GetProbes: function() {
        probe_helper.getProbes({
          then: response => {
              let tmp_probes = response.data

              this.probes = {}
              tmp_probes.forEach((item, i, arr)=> {
                  this.probes[item.id] = item.name
              })

              this.probes_to_show = []

              response.data.forEach((item, i, arr) => {
                  this.probes_to_show.push({
                      value: item.id,
                      text: item.name
                  })
              });
            }
        })
      },
      GetDevices: function() {
        device_helper.getDevices({
          then: response => {
            this.devices = null
            this.devices = response.data
          }
        })
      },
      GetProbeAssignation: function() {
        probe_helper.getProbeAssignation({
          then: response => {
              this.probe_assignation = response.data

              this.probe_assignation_dict = {}

              this.probe_assignation.forEach((item) => {
                if (!(item.host_id in this.probe_assignation_dict))
                {
                  this.probe_assignation_dict[item.host_id] = []
                }
                this.probe_assignation_dict[item.host_id].push(item.probe_id)
              })
            }
        })
      },
      AddHost(event)
      {
        device_helper.addDevice({
          data: {
              ip: this.HostIP,
              notes: this.HostNote,
            }
        })
      },
      DeleteItem(row) {
        device_helper.deleteDevice({
          data: {
              id: row.item.id
            }
        })
      },
      UpdateItem: function(row) {
            this.old_available_probes = {}

            this.probe_assignation_dict[row.item.id].forEach((probe_id) => {
              this.old_available_probes[this.probes[probe_id]] = true
            })

            this.old_data = row.item

            this.showModal = true
        },
    },
    mounted() {
      this.GetProbes()
      this.GetDevices()
      this.GetProbeAssignation()
    }
  }
</script> 