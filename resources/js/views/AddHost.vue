<template>
    <custom-add-modal  @close="close" @addButtonClick="OnAddButtonClick">
        <template v-slot:header>
            <p>Добавление устройства</p>
        </template>

        <template v-slot:body>
            <b-container fluid>
                <b-row cols=2>
                    <b-col>
                        <b-form-input v-model="new_data.name" placeholder="Введите название устройства"></b-form-input>
                    </b-col>
                    <b-col>
                        <b-form-input v-model="new_data.ip" placeholder="Введите ip адрес устройства"></b-form-input>
                    </b-col>
                </b-row>
                <b-row cols=4>
                    <b-col v-for="probe in probes" :key="probe.value">
                        <b-form-checkbox v-model="checked_probes[probe.text]" name="check-button" size="lg" switch>
                            {{probe.text}}
                        </b-form-checkbox>
                    </b-col>
                </b-row>
                <b-row cols=2 v-if="checked_probes['fping']">
                    <b-col>
                        <b-form-input placeholder="Размер icmp пакета в байтах"></b-form-input>
                    </b-col>
                    <b-col>
                        <b-form-input placeholder="Количество icmp пакетов"></b-form-input>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <b-form-textarea
                        v-model="new_data.notes"
                        placeholder="Заметки"
                        rows="3"
                        max-rows="9"
                        ></b-form-textarea>
                    </b-col>
                </b-row>
            </b-container>
        </template>
    </custom-add-modal>   
</template>

<script>
import customAddModal from './CustomAddModalWindow'

import * as device_helper from '../helpers/devices.js'

export default {
    components: {
        'custom-add-modal': customAddModal,
    },
    data: function() {
        return {
            new_data: {
                ip: null,
                name: null,
                notes: null,
                available_probes: []
            },
            checked_probes:{}
        }
    },
    props: {
        probes: Array,
        old_data: Object,
        old_available_probes: Object,
    },
    methods: {
        OnAddButtonClick: function(event) {
            let probes_values = {}

            this.probes.forEach((item) => {
                probes_values[item.text] = item.value
            });

            this.new_data.available_probes = []
            for(var key in this.checked_probes){
                if(this.checked_probes[key]) {
                    this.new_data.available_probes.push(probes_values[key])
                }
            }

            if(this.old_data !== null) {
                device_helper.updateDevice({
                    data: {
                        id: this.old_data.id,
                        new: this.new_data,
                    },
                    then: () => {
                        this.$emit('close')
                    }
                })
            } else {
                device_helper.addDevice({
                    data: this.new_data,
                    then: () => {
                        this.$emit('close')
                    }
                })
            }
        },
        close: function() {
            this.$emit('close')
        },
    },
    mounted() {
        if(this.old_data !== null) {
            this.new_data = this.old_data
            this.checked_probes = this.old_available_probes
        }
    }
}
</script>
<style>
@import url('../../css/ModalWindow.css');
</style>
