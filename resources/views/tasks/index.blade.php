@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tasks</h2>

        <div class="mb-3">
            <label for="projectFilter">Filter by Project:</label>
            <select id="projectFilter" class="form-control" x-model="selectedProject" x-on:change="fetchTasks()">
                <option value="">All Projects</option>
                //Loop all the projects
                //Todo : project filter function not implemented fully
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                @endforeach
            </select>
        </div>

        <!--Task list with table -->
        <div x-data="taskList()" x-init="init()">
            <table class="table table-bordered" id="taskTable">
                <thead>
                <tr>
                    <th>Task ID</th>
                    <th>Task Name</th>
                </tr>
                </thead>
                <tbody x-ref="taskList" id="taskList">
                <template x-for="task in filteredTasks" :key="task.id">
                    <tr :data-id="task.id" :data-index="task.priority">
                        <td x-text="task.id"></td>
                        <td x-text="task.name"></td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Include SortableJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>

    <script>
        function taskList() {
            return {
                //Initiate task data
                tasks: @json($tasks),
                selectedProject: '',
                selectedPriority: '',

                init() {
                    this.$nextTick(() => {
                        this.initSortable();  // Initialize sortable functionality after Alpine.js renders
                    });
                },

                //Todo :Fetch tasks from the backend based on the selected project ID
                fetchTasks() {

                    // If no project is selected, show all tasks
                    if (!this.selectedProject) {
                        this.tasks = @json($tasks);
                        return;
                    }


                    //Todo : pass project_ID and get filtered task list by project
                    fetch(`/api/tasks?project_id=${this.selectedProject}`)
                        .then(response => response.json())
                        .then(data => {
                        })
                        .catch(error => console.error('Error fetching tasks:', error));
                },

                get filteredTasks() {
                    let tasks = this.tasks;

                    // TODO : Filter by priority
                    if (this.selectedPriority) {
                        tasks = tasks.filter(task => task.priority == this.selectedPriority);
                    }

                    return tasks;
                },

                //Update task priority
                updatePriority(taskId, newPriority) {
                    //Calling to task priority end-point
                    fetch(`/api/tasks/${taskId}/update-priority`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ priority: newPriority }) //Send only the updated priority
                    })
                        .then(response => response.json())
                        .catch(error => console.error('Error updating priority:', error));
                },

                initSortable() {
                    const el = this.$refs.taskList;

                    new Sortable(el, {
                        onEnd: (evt) => {
                            const updatedTask = Array.from(el.children)[evt.newIndex+1];//Get the dragged row
                            const newPriority = evt.newIndex + 1;// Set the new priority based on row position
                            const taskId = updatedTask.dataset.id;// Get the ID of the dragged task

                            //send the priority update for this specific task
                            if (taskId) {
                                this.updatePriority(taskId, newPriority); //Now send the priority update for this task
                            } else {
                                console.error('Task ID not found!');
                            }
                        }
                    });
                }
            }
        }
    </script>
@endsection
