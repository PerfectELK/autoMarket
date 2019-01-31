<template>
    <div class="w-100 modal__body">
    <label for="type">Тип:</label>
    <select name="" id="type" class="form-control" v-model="currentType" v-on:change="this.changeType">
        <option value="0">Владелец</option>
        <option value="1">Арендатор</option>
    </select>
        <master-car v-if="this.master"></master-car>
        <tenant v-if="this.tenant"></tenant>
    </div>
</template>

<script>
    const masterCar = require('vue!./forms/addMasterOfCar.vue');
    const tenant = require('vue!./forms/addTenant.vue');
    module.exports = {
        components:{
            masterCar:masterCar,
            tenant: tenant,
        },
        data:function(){
            return{
                currentType:0,
                master: true,
                tenant: false,
            }
        },
        methods:{
            changeType:function(){
                let type = parseInt(this.currentType);
                if(type){
                    this.master = false;
                    this.tenant = true;
                }else{
                    this.master = true;
                    this.tenant = false;
                }
            }
        }

    }
</script>

<style>
    .modal__body{
        flex-direction: column;
        align-items: baseline;
    }
</style>