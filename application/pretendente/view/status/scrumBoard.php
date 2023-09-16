<div class="p-5">
    <div class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">                                    
        <div class="relative pt-5">
            <div class="perfect-scrollbar -mx-2">
                <div class="overflow-y-auto flex flex-col items-start flex-nowrap gap-5 pb-2 px-2">                    
                    <!-- Status -->
                    <template x-for="project in projectList" :key="project.id" >
                        <div class="panel w-full flex-none border border-dark">
                            <div class="flex justify-between mb-3">
                                <h4 x-text="project.title" class="text-primary font-bold "></h4>
                                <div class="flex items-center">
                                    <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                                        <button type="button" class="hover:text-primary" @click="toggle">

                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-70 hover:opacity-100">
                                                <circle cx="5" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                                <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                                <circle cx="19" cy="12" r="2" stroke="currentColor" stroke-width="1.5"></circle>
                                            </svg>
                                        </button>
                                        <ul x-cloak x-show="open" x-transition x-transition.duration.300ms class="ltr:right-0 rtl:left-0">
                                            <li><a href="javascript:;" @click="toggle, addEditProject(project)">Edit</a></li>
                                            <li><a href="javascript:;" @click="toggle, deleteProject(project)">Delete</a></li>
                                            <li><a href="javascript:;" @click="toggle, clearProjects(project)">Clear All</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- task list -->
                            <div class="sortable-list" :data-id="project.id">
                                <template x-for="task in project.tasks">
                                    <div :key="project.id" :data-id="project.id" class="flex shadow bg-[#f4f4f4] dark:bg-[#262e40] p-3 pb-5 rounded-md space-y-3 cursor-move">                                        
                                        <div class="flex items-center w-max">
                                            <img class="w-9 h-9 rounded-full ltr:mr-2 rtl:ml-2 object-cover" src="<?php echo BASE_THEME_URL; ?>/assets/images/profile-3.jpeg" />
                                            <div class="hover:text-primary" x-text="task.title"></div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>                          
            <!-- Dados vindos do ajax -->
            <div id="resultStatusScrumBoard"></div>
        </div>
    </div>
</div>