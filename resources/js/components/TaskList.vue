<template>
    <div>
        <ul>
            <li v-for="task in tasks" v-text="task"></li>
            <input type="text" v-model="newTask" @blur="addTask">
        </ul>
    </div>

</template>

<script>
    export default {
      data(){//inlezen van data
          return{
              tasks:[],
              newTask:'',
          };
      },
        created(){//taken ophalen via axios
          axios.get('tasks').then(response=>(this.tasks = response.data));
          window.Echo.channel('tasks').listen('TaskCreated', ({task})=>{
              this.tasks.push(task.body);
            })
        },
        methods:{
          addTask(){
              axios.post('tasks', {body:this.newTask});//db toevoeging
              
              this.tasks.push(this.newTask);//vullen van de array tasks.
              this.newTask='';
          }
        }
    }
</script>
