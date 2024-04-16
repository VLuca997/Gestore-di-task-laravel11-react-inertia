import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import { PROJECT_STATUS_CLASS_MAP, PROJECT_STATUS_TEXT_MAP } from "@/constants.jsx"; // mappatura
import TasksTable from "../Task/TasksTable";

export default function Show({ auth, project, tasks,  queryParams }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            header=
            {<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {`Project "${project.name}"`}
            </h2>}


        >
            <Head title={`Project "${project.name}"`} />
                            {/* <pre  className=" text-wrap h-100">{JSON.stringify(project)}</pre> */}
        {/* PROJECT */}
        <div className=" overflow-auto">
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        {/* IMAGE PATH */}
                        <div>
                            <img className="w-full h-64 object-cover" src={project.image_path} />
                        </div>
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <div className="grid gap-1 mt-2 grid-cols-2">
                                {/* LEFT COLUMNS */}
                                <div>
                                    <div className="mt-4">
                                        <label className="font-bold text-lg">Project ID</label>
                                        <div className="mt-1"><p className="flex">N° <strong className="text-green-500 mx-3">{project.id}</strong></p> </div>
                                    </div>
                                    <div className="mt-4">
                                        <label className="font-bold text-lg">Project Name</label>
                                        <p className="mt-1">{project.name}</p>
                                    </div>

                                    <div className="mt-4">
                                        <label className="font-bold text-lg">Project Status</label>
                                        <div className="mt-1">
                                        <span className={
                                            "px-2 py-1 rounded text-white " + PROJECT_STATUS_CLASS_MAP[project.status]
                                        }>
                                            {PROJECT_STATUS_TEXT_MAP[project.status]}
                                        </span>
                                    </div>
                                    <div className="mt-4">
                                        <label className="font-bold text-lg">Created By</label>
                                        <p className="mt-1 text-green-500">{project.createdBy.name}</p>
                                    </div>
                                </div>

                                </div>

                                {/* RIGHT COLUMNS */}
                                <div>
                                    <div className="mt-4">
                                        <label className="font-bold text-lg">Due Date</label>
                                        <p className="mt-1">{project.due_date}</p>
                                    </div>
                                    <div className="mt-4">
                                        <label className="font-bold text-lg">Create Date</label>
                                        <p className="mt-1">{project.created_at}</p>
                                    </div>
                                    <div className="mt-4">
                                        <label className="font-bold text-lg">Updated By</label>
                                        <p className="mt-1">{project.updatedBy.name}</p>
                                    </div>

                                </div>
                            </div>
                            {/* SECTION DESCRIPTION AND UPDATE OR DELETE */}
                            <div>
                                <div className="mt-4">
                                        <label className="font-bold text-lg text-nowrap ">Project Description</label>
                                        <p className="mt-3 font-bold">{project.description}</p>
                                </div>
                                <div className="mt-5 mx-3 border flex justify-evenly">
                                    <Link href={route('project.edit',project.id)}
                                        className="font-medium  text-yellow-300 dark:text-yellow-300 hover:underline mx-1"
                                    >
                                        Edit
                                    </Link>
                                    <Link href={route('project.destroy',project.id)}
                                        className="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
                                    >
                                        Delete
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {/* TASKS */}
        <div className=" overflow-auto">
            <div className="py-6">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                        <div className="p-6 text-gray-900 dark:text-gray-100">

                            <TasksTable tasks={tasks} queryParams={queryParams} hideProjectColumn={true} />

                        </div>
                    </div>
                </div>
            </div>

        </div>



        </AuthenticatedLayout>

    )
}
