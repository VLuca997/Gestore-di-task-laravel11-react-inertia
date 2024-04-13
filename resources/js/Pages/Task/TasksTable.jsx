import TableHeading from "@/Components/TableHeading"; // componente per riutilizzare heading della tabella.
import Pagination from "@/Components/Pagination.jsx";
import SelectInput from "@/Components/SelectInput.jsx";
import TextInput from "@/Components/TextInput";
import { Link, router } from "@inertiajs/react";
import { PROJECT_STATUS_CLASS_MAP, PROJECT_STATUS_TEXT_MAP } from "@/constants.jsx"; // mappatura


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
//SMISTAMENTO:
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
                            {!hideProjectColumn && <th className="px-3 py-2 text-red-300">Project Name</th>}
                            <TableHeading
                                name='name'
                                sort_field={queryParams.sort_field}
                                sort_direction = {queryParams.sort_direction}
                                sortChanged={sortChanged}
                            >
                                NAME
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
                                DUE DATE
                            </TableHeading>
                            <th className="px-3 py-2">Created By</th>
                            <th className="px-3 py-2 text-right">Actions</th>
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
                            <th className="px-3 py-2"> </th>
                            <th className="px-3 py-2"> </th>
                            <th className="px-3 py-2"> </th>
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
                                {!hideProjectColumn && <td className="px-3 py-2 text-red-300">{task.project.name}</td>}
                                <td className="px-3 py-2">{task.name}</td>
                                <td>
                                    <span className={
                                        "px-2 py-1 rounded text-white " +
                                        PROJECT_STATUS_CLASS_MAP[task.status]
                                    }>

                                    {PROJECT_STATUS_TEXT_MAP[task.status]}
                                    </span>
                                </td>
                                <td className="px-3 py-2 text-nowrap">{task.created_at}</td>
                                <td className="px-3 py-2 text-nowrap">{task.due_date}</td>
                                <td className="px-3 py-2">{task.createdBy.name}</td>
                                <td className="px-3 py-2">
                                    <Link href={route('task.edit',task.id)}
                                        className="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                    >
                                        Edit
                                    </Link>
                                    <Link href={route('task.destroy',task.id)}
                                        className="font-medium text-red-600 dark:text-red-500 hover:underline mx-1"
                                    >
                                        Delete
                                    </Link>
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
