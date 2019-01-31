<template>
    <div class="table table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Автомобиль</th>
                    <th>Цена</th>
                    <th>Дата окончания</th>
                    <th>Прибыль</th>
                </tr>
            </thead>
            <tbody>
            <tr v-for="rent in rents">
                <td>{{ rent.carID }}. {{ rent.title }}</td>
                <td>{{ rent.price }}</td>
                <td>{{ rent.endFormatted }}</td>
                <td>{{ rent.profit }}</td>
            </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>Итого:</td>
                    <td></td>
                    <td></td>
                    <td>{{ profitCommon }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    const axios = require('axios');

    module.exports = {
        data:function(){
            return{
                rents:[],
                profitCommon:'',
            }
        },
        methods:{
            getRents:function(){
                let param = $.param({data:{c:'RentController',m:'getRentsForTable'}});
                axios.post('/api',param,{ headers: {'Content-type': 'application/x-www-form-urlencoded',}}).
                then(response => {
                    console.log(response.data);
                        this.rents = response.data;
                        this.profitCommon = this.getCommonProfit();
                })
            },
            getCommonProfit:function(){
                let sum = 0;
                this.rents.forEach((item,index,array) =>{
                    sum += parseInt(item.profit);
                });
                return sum;
            }
        },
        created(){
            this.getRents();
        }
    }
</script>

<style>

</style>