<template>
    <b-container>
        <b-row>
            <b-col>
                <b-form-select v-model="query.host_ip" v-bind:options="hosts_list" v-on:change="getSelectedItem">
                    <template #first>
                        <b-form-select-option :value="null" disabled>-- Выберите устройство --</b-form-select-option>
                    </template>
                </b-form-select>
            </b-col>
            <b-col>
                <b-form-select v-model="query.probe_type" v-bind:options="base_probes_list" v-on:change="probeSelected">
                    <template #first>
                        <b-form-select-option :value="null" disabled>-- Выберите тип метрики --</b-form-select-option>
                    </template>
                </b-form-select>
            </b-col>
            <b-col>
                <b-form-select v-model="query.field" v-bind:options="fields_list" v-on:change="getSelectedItem">
                    <template #first>
                        <b-form-select-option :value="null" disabled>-- Выберите искомое поле --</b-form-select-option>
                    </template>
                </b-form-select>
            </b-col>
        </b-row>
        <b-row cols=1>
            <b-col v-for="target in targets" :key="target.id">
                <chart 
                v-bind:host_ip=query.host_ip
                v-bind:resource_name=target.resource_name
                time="43200"
                v-bind:probe_type=query.probe_type
                v-bind:field=query.field
                ></chart>
            </b-col>
        </b-row>
    </b-container>
</template>
<script>
import * as device_helper from '../helpers/devices.js'
import * as probe_helper from '../helpers/probes.js'
import * as target_helper from '../helpers/targets.js'
import * as config_helper from '../helpers/config.js';

//import ChartVue from './Chart.vue'

export default {
    components: {
//        'chart' : ChartVue,
    },
    data: function() {
        return {
            targets: null,
            base_probes: null,
            base_probes_list: [],
            hosts: null,
            hosts_list: [],
            probes: null,

            fields_list: null,

            query: {
                probe_type: null,
                host_ip: null,
                field: null,
            },

            ping_targets: null,
            speedtest_targets: null,
            available_fields: {},
        }
    },
    methods: {
        getSelectedItem: function(event) {
            this.targets = null
            this.GetTargets()
        },
        probeSelected: function(event) {
            this.query.field = null
            this.targets = null
            this.fields_list = []

            this.available_fields[this.query.probe_type].forEach((field_name) => {
                this.fields_list.push({
                    value: field_name,
                    text: field_name
                })
            })

            this.GetTargets()  
        },
        GetBaseProbes: function() {
            probe_helper.getBaseProbes({
                then: response => {
                        this.base_probes = response.data

                        this.base_probes.forEach((item) => {
                            this.base_probes_list.push({
                                value: item.name,
                                text: item.name
                            })
                        })

                        // this.base_probes_list = {}
                        // this.base_probes.forEach((item) => {
                        //     this.base_probes_list[item.id] = item.name
                        // });
                    }
            })
        },
        GetProbes: function() {
            probe_helper.getProbes({
                then: response => {
                    let tmp_probes = response.data

                    this.probes = {}
                    tmp_probes.forEach((item)=> {
                        this.probes[item.id] = item.name
                    })
                }
            })
        },
        GetDevices: function() {
            device_helper.getDevices({
                then: response => {
                    this.devices = response.data

                    this.devices.forEach((item) => {
                        this.hosts_list.push({
                            value: item.ip,
                            text: item.ip
                        })
                    })
                }
            })
        },
        GetTargets: function() {
            if (this.query.probe_type != null && this.query.host_ip != null && this.query.field != null)
            {
                target_helper.getTargets({
                    params: {
                        probe_type: this.query.probe_type
                    },
                    then: response => {
                        this.targets = response.data
                    }
                })
            }
        },
        GetAvailableFields: function() {
            config_helper.getAvailableFields({
                then: (response) => {
                    this.available_fields = response.data
                }
            })
        },
        SeparateTargets: function() {
            this.base_probes_list.forEach((item) => {
                console.log(item)
            })
        }
    },
    mounted() {
        this.GetAvailableFields()
        this.GetBaseProbes()
        this.GetProbes()
        this.GetDevices()
    },
}
</script>