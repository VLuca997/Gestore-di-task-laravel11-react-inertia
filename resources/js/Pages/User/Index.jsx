//LAYOUT USER AUTENTICATO.
import Pagination from "@/Components/Pagination.jsx";
// import SelectInput from "@/Components/SelectInput.jsx";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
// import { USER_STATUS_CLASS_MAP, USER_STATUS_TEXT_MAP } from "@/constants.jsx"; // mappatura
import { Head, Link, router } from "@inertiajs/react";

// import {ChevronUpIcon, ChevronDownIcon} from "@heroicons/react/20/solid"; // pacchetto icone ora inserito nel componente TableHeading
import TableHeading from "@/Components/TableHeading"; // componente per riutilizzare heading della tabella.

export default function Index({auth, users, queryParams = null, success}){


    queryParams = queryParams || {};

//SEARCHBAR FUNCTION X LA RICERCA TRAMITE NOME-----
const searchFieldChanged =(name, value) => {
    if(queryParams){
        queryParams[name] = value;

    }else{
        delete queryParams[name];
    }
    //REDIRECT CON I PARAMETRI PASSATI
    router.get(route('user.index'),queryParams);
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
    router.get(route("user.index"), queryParams );
}

//---------------------------------------------------------
//DELETE FUNCION USER-----------------------------------
    const deleteUser = (user) => {
        if(!window.confirm('Are you sure you want to delete the user?')){
            return;
        }
        router.delete(route('user.destroy', user.id))
    }
//---------------------------------------------------------


    return(
        <AuthenticatedLayout
            user={auth.user}
            header=
            {<div className="flex justify-between items-center">
                    <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        USERS
                    </h2>
                    {/* ADD NEW USER! */}
                    <Link
                        href= {route('user.create')}
                        className="bg-emerald-500 py-1 px-3 text-white rounded shadow transition-all hover:bg-emerald-600"
                    >
                        Add New User!
                    </Link>
            </div>}
        >
        <Head title="User" />

        <div className="py-12">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {success && (<div className="bg-emerald-500 py-2 px-4 text-white rounded mb-4">
                    {success}
                </div>)}

                <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div className="p-6 text-gray-900 dark:text-gray-100">
                        <div className="overflow-auto">
                            <table className="w-full text-sm text-left trl:text-right text-gray-500 dark:text-gray-400">
                                    {/* FILTRO CLICK SUL NOME  */}
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
                                            <TableHeading
                                                name='name'
                                                sort_field={queryParams.sort_field}
                                                sort_direction = {queryParams.sort_direction}
                                                sortChanged={sortChanged}
                                            >
                                                NAME
                                            </TableHeading>
                                            <TableHeading
                                                name='email'
                                                sort_field={queryParams.sort_field}
                                                sort_direction = {queryParams.sort_direction}
                                                sortChanged={sortChanged}
                                            >
                                                Email
                                            </TableHeading>
                                            <TableHeading
                                                name='created_at'
                                                sort_field={queryParams.sort_field}
                                                sort_direction = {queryParams.sort_direction}
                                                sortChanged={sortChanged}
                                            >
                                                CREATE DATA
                                            </TableHeading>

                                            <th className="px-3 py-2 text-right">Actions</th>
                                        </tr>
                                    </thead>

                                    {/* FILTRI A RICERCA  */}
                                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                                        <tr className="text-nowrap">
                                            <th className="px-3 py-2"></th>
                                            <th className="px-3 py-2">
                                                {/* SEARCHBAR */}
                                                <TextInput
                                                    className="w-full"
                                                    defaultValue = {queryParams.name}
                                                    placeholder="User name.."
                                                    onBlur={e => searchFieldChanged('name', e.target.value)}
                                                    onKeyPress={e => onKeyPress('name', e)}

                                                />

                                            </th>
                                            <th className="px-3 py-2">
                                                {/* SEARCHBAR */}
                                                <TextInput
                                                    className="w-full"
                                                    defaultValue = {queryParams.email}
                                                    placeholder="User email"
                                                    onBlur={e => searchFieldChanged('email', e.target.value)}
                                                    onKeyPress={e => onKeyPress('email', e)}

                                                />

                                            </th>
                                            <th className="px-3 py-2"> </th>
                                            <th className="px-3 py-2"></th>
                                        </tr>
                                    </thead>

                                    {/* BODY SPA */}
                                    <tbody>
                                        {users.data.map((user) => (
                                            <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700" key={user.id}>
                                                <td className="px-3 py-2">{user.id}</td>
                                                <th className="px-3 py-2 hover:underline text-nowrap hover:text-red-100">
                                                    {user.name}
                                                </th>
                                                <td>
                                                    {user.email}
                                                </td>
                                                <td className="px-3 py-2 text-nowrap">
                                                    {user.created_at}
                                                </td>

                                                <td className="px-3 py-2 text-nowrap">
                                                    <Link href={route('user.edit',user.id)}
                                                        className="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1"
                                                    >
                                                        Edit
                                                    </Link>
                                                    <button
                                                        onClick={(e) => deleteUser(user)}
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
                        <Pagination links={users.meta.links}/>
                    </div>
                </div>
            </div>
        </div>

        </AuthenticatedLayout>
    )
}
