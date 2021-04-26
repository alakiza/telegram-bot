<template>
    <div class="modal-mask">
        <div class="modal-wrapper">
            <div class="modal-container">

                <div class="modal-header" >
                    <b-container fluid>
                        <b-row>
                            <b-col cols=10>
                                <slot name='header'>
                                    <p>Выходит Маяковский из кабака, окруженный стайкой девиц</p>
                                </slot>
                            </b-col>
                            <b-col cols=2>
                                <b-button-close class="modal-default-button" @click="close">
                            
                                </b-button-close>
                            </b-col>
                        </b-row>
                    </b-container>
                </div>

                <div class="modal-body">
                    <slot name='body'>
                        <b-container fluid>
                            <b-row>
                                <b-col cols=8>
                                    <p>Лежит</p>
                                    <p>Безжизненное</p>
                                    <p>Тело</p>
                                    <p>На нашем</p>
                                    <p>Жизненном</p>
                                    <p>Пути.</p>
                                </b-col>
                            </b-row>
                        </b-container>
                    </slot>
                </div>

                <div class="modal-footer">
                    <slot name='footer'>
                        <p>Маяковский и Есенин</p>
                    </slot>
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
  export default {
    name: 'modal',
    methods: {
      close() {
        this.$emit('close');
      },
    },
  };
</script>

<style>
@import url('../../css/ModalWindow.css');
</style>
