import TableHeading from "@/Components/TableHeading"; // componente per riutilizzare heading della tabella.
import Pagination from "@/Components/Pagination.jsx";
import SelectInput from "@/Components/SelectInput.jsx";
import TextInput from "@/Components/TextInput";
import { Link, router } from "@inertiajs/react";
import { TASK_STATUS_CLASS_MAP, TASK_STATUS_TEXT_MAP } from "@/constants.jsx"; // mappatura


export default function TasksTable({

    tasks,
    queryParams=null,
    hideProjectColumn = false,
}){
    queryParams = queryParams || {};

    //SEARCHBAR FUNCTION X LA RICERCA TRAMITE NOME-----
const searchFieldChanged =(name, value) => {
    if(queryParams){
        queryParams[name] = value;

    }else{
        delete queryParams[name];
    }
    //REDIRECT CON I PARAMETRI PASSATI
    router.get(route('task.index'),queryParams);
}

//TASTO ENTER COME INPUT D'AVVIO
const onKeyPress = (name, e) => {

    if(e.key !== 'Enter') return;

    searchFieldChanged(name, e.target.value);
}
//-------------------------------------------------
//SORTING:
const sortChanged = (name) => {
    if(name === queryParams.sort_field){
        if(queryParams.sort_direction === 'asc'){
            queryParams.sort_direction = 'desc';
        }else{
            queryParams.sort_direction = 'asc';
        }
    }else{
        queryParams.sort_field = name;
        queryParams.sort_direction = 'asc';
    }
    router.get(route("task.index"), queryParams );
}

//---------------------------------------------------------
//CRUD DELETE TASK
const deleteTask = (task) => {
    if(!window.confirm('Are you sure you want to delete the Task??')){
        return;
    }
    router.delete(route('task.destroy', task.id))
}
//---------------------------------------------------------

    return(
    <>
        <div className="overflow-auto">
            <table className="w-full text-sm text-left trl:text-right text-gray-500 dark:text-gray-400">
                    {/* FILTRAGGIO PER CLICK */}
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                        <tr className="text-nowrap">
                            <TableHeading
                                name='id'
                                sort_field={queryParams.sort_field}
                                sort_direction = {queryParams.sort_direction}
                                sortChanged={sortChanged}
                            >
                                ID
                            </TableHeading>
                            <th className="px-3 py-2">Image</th>
                            {!hideProjectColumn && <th className="px-3 py-2 text-orange-600">Project Name</th>}
                            <TableHeading
                                name='name'
                                sort_field={queryParams.sort_field}
                                sort_direction = {queryParams.sort_direction}
                                sortChanged={sortChanged}
                            >
                                TASK NAME
                            </TableHeading>
                            <TableHeading
                                name='status'
                                sort_field={queryParams.sort_field}
                                sort_direction = {queryParams.sort_direction}
                                sortChanged={sortChanged}
                            >
                                STATUS
                            </TableHeading>
                            <TableHeading
                                name='created_at'
                                sort_field={queryParams.sort_field}
                                sort_direction = {queryParams.sort_direction}
                                sortChanged={sortChanged}
                            >
                                CREATE DATA
                            </TableHeading>
                            <TableHeading
                                name='due_date'
                                sort_field={queryParams.sort_field}
                                sort_direction = {queryParams.sort_direction}
                                sortChanged={sortChanged}
                            >
                                DEADLINES
                            </TableHeading>
                            <th className="px-3 py-2 text-green-500">Created By</th>
                            <th className="px-3 py-2 text-yellow-500">Assigned to</th>
                            <th className="px-3 py-2 text-purple-500">Actions</th>
                        </tr>
                    </thead>

                    {/* FILTRAGGIO PER INPUT */}
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                        <tr className="text-nowrap">
                            <th className="px-3 py-2"></th>
                            <th className="px-3 py-2"></th>
                            {!hideProjectColumn && <th className="px-3 py-2"></th>}
                            <th className="px-3 py-2">
                                {/* SEARCHBAR */}
                                <TextInput
                                    className="w-full"
                                    defaultValue = {queryParams.name}
                                    placeholder="Task name.."
                                    onBlur={e => searchFieldChanged('name', e.target.value)}
                                    onKeyPress={e => onKeyPress('name', e)}

                                />

                            </th>
                            <th className="px-3 py-2">
                                {/* SEARCH INPUT */}
                                <SelectInput
                                    className="w-full"
                                    defaultValue = {queryParams.status}
                                    onChange={e => searchFieldChanged('status' ,e.target.value)}
                                >
                                    <option value="">Select Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Complete</option>

                                </SelectInput>
                                </th>
                            <th className="px-3 py-2"></th>
                            <th className="px-3 py-2"></th>
                            <th className="px-3 py-2"></th>
                            <th className="px-3 py-2"></th>
                            <th className="px-3 py-2"></th>
                        </tr>
                    </thead>


                    <tbody>
                        {tasks.data.map((task) => (
                            <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={task.id}>

                                <td className="px-3 py-2">{task.id}</td>
                                <td className="px-3 py-2">
                                    <img src={task.image_path} style={{width:70, height:30}} />
                                </td>
                                {!hideProjectColumn && <td className="px-3 py-2 text-orange-600">{task.project.name}</td>}
                                <td className="px-3 py-2">{task.name}</td>
                                <td>
                                    <span className={
                                        "px-2 py-1 rounded text-white " +
                                        TASK_STATUS_CLASS_MAP[task.status]
                                    }>

                                    {TASK_STATUS_TEXT_MAP[task.status]}
                                    </span>
                                </td>
                                {/* <pre className="text-red-500">{JSON.stringify(task)}</pre>
                                    grazie a questo ho capito come accedere e far stampare la riga assignedUser.name
                                    ( p.s ricordavo e in piu manco ho visto l'esempio di createdBy.name ahahah soz :') )
                                */}
                                <td className="px-3 py-2 text-nowrap">{task.created_at}</td>
                                <td className="px-3 py-2 text-nowrap">{task.due_date}</td>
                                <td className="px-3 py-2 text-green-500">{task.createdBy.name}</td>
                                <td className="px-3 py-2 text-yellow-500">{task.assignedUser.name}</td>
                                <td className="px-3 py-2 text-nowrap">
                                    <Link href={route('task.edit',task.id)}
                                        className="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                    >
                                        Edit
                                    </Link>
                                    <button
                                        onClick={(e) => deleteTask(task)}
                                        className="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
                                    >
                                        Delete
                                    </button>

                                </td>
                            </tr>
                        ))}
                    </tbody>
            </table>
        </div>
        <Pagination links={tasks.meta.links}/>
    </>
    )
}
