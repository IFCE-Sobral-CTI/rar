import React, { useEffect, useState } from "react";
import { Link, router } from "@inertiajs/react";
import Pagination from "@/Components/Dashboard/Pagination";
import Panel from "@/Components/Dashboard/Panel";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Status from "./Components/Status";
import SelectOnly from "@/Components/Form/SelectOnly";

function Index({ requirements, can, request, data }) {
    const [status, setStatus] = useState(request.status);
    const [type, setType] = useState(request.type);
    const [course, setCourse] = useState(request.course);
    const [semester, setSemester] = useState(request.semester);
    const [trash, setTrash] = useState(false);

    const onChangeHandle = (event) => {
        switch(event.target.name) {
            case 'status':
                setStatus(event.target.value);
                break;
            case 'type_of_requirement':
                setType(event.target.value);
                break;
            case 'type_of_course':
                setCourse(event.target.value);
                break;
            case 'semester':
                setSemester(event.target.value);
                break;
        }
    }

    useEffect(() => {
        const debounce = setTimeout(() => {
            router.visit(route(route().current()), {data: {status, type, course, semester, page: request.page}, preserveState: true, replace: true});
        }, 300);

        if (status || type || course || semester)
            setTrash(true)

        return () => clearTimeout(debounce);
    }, [status, type, course, semester]);

    const table = requirements.requirements.data.map((item, index) => {
        return (
            <tr key={index} className={"border-t transition hover:bg-neutral-100 " + (index % 2 == 0? 'bg-neutral-50': '')}>
                <td className="px-1 py-3 font-light">
                    <Link href={can.view? route('requirements.show', item.id): route('requirements.index', {term: term, page: currentPage})}>
                        {item.requirement_type.description}
                    </Link>
                </td>
                <td className="px-1 py-3 font-light">
                    <Link href={can.view? route('requirements.show', item.id): route('requirements.index', {term: term, page: currentPage})}>
                        {item.enrollment.number}
                    </Link>
                </td>
                <td className="px-1 py-3 font-light">
                    <Link href={can.view? route('requirements.show', item.id): route('requirements.index', {term: term, page: currentPage})}>
                        {item.enrollment.student.name}
                    </Link>
                </td>
                <td className="px-1 py-3 font-light">
                    <Link href={can.view? route('requirements.show', item.id): route('requirements.index', {term: term, page: currentPage})}>
                        {<Status value={item.status} />}
                    </Link>
                </td>
                <td className="flex justify-end py-3 pr-2 text-neutral-400">
                    <Link href={can.view? route('requirements.show', item.id): route('requirements.index', {term: term, page: currentPage})}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                            <path fillRule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </Link>
                </td>
            </tr>
        );
    });

    return (
        <>
            <AuthenticatedLayout
                titleChildren={'Relatório de Requerimentos'}
                breadcrumbs={[
                    { label: 'Requerimentos', url: route('requirements.index') },
                    { label: 'Relatório' },
                ]}
            >
                <Panel>
                    <div className="flex justify-between items-center gap-2 px-2">
                        <h2 className="text-xl text-neutral-500 font-semibold">Filtros</h2>
                        {trash &&
                            <Link
                                href={route('requirement_reports.index', {status: '', type: '', course: '', semester: '', page: request.page?? ''})}
                                className="flex px-1 gap-1 items-center border border-transparent text-sm rounded-lg text-white transition ease-in-out duration-150 focus:ring-2 bg-red-500 hover:bg-red-600 focus:ring-red-300"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16" className="w-3 h-3">
                                    <path fill="currentColor" d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1l-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                </svg>
                                <span className="text-sm font-light">Limpar filtros</span>
                            </Link>
                        }
                    </div>
                    <div className="flex justify-between">
                        <div className="flex-1 border-r border-neutral-400 px-2">
                            <SelectOnly
                                value={status}
                                data={data.status}
                                onChange={onChangeHandle}
                                label={'Situação'}
                                name={'status'}
                            />
                        </div>
                        <div className="flex-1 border-r border-neutral-400 px-2">
                            <SelectOnly
                                value={type}
                                data={data.type_of_requirement}
                                onChange={onChangeHandle}
                                label={'Tipo de requerimento'}
                                name={'type_of_requirement'}
                            />
                        </div>
                        <div className="flex-1 border-r border-neutral-400 px-2">
                            <SelectOnly
                                value={course}
                                data={data.type_of_course}
                                onChange={onChangeHandle}
                                label={'Tipo de curso'}
                                name={'type_of_course'}
                            />
                        </div>
                        <div className="flex-1 px-2">
                            <SelectOnly
                                value={semester}
                                data={data.semester}
                                onChange={onChangeHandle}
                                label={'Semestre'}
                                name={'semester'}
                            />
                        </div>
                    </div>
                </Panel>
                <Panel className="">
                    <table className="w-full table-auto text-neutral-600">
                        <thead>
                            <tr className="border-b">
                                <th className="px-1 pt-3 font-semibold text-left w-2/12">Tipo</th>
                                <th className="px-1 pt-3 font-semibold text-left w-2/12">Matricula</th>
                                <th className="px-1 pt-3 font-semibold text-left w-6/12">Discente</th>
                                <th className="px-1 pt-3 font-semibold text-left w-2/12">Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {table}
                        </tbody>
                    </table>
                    <Pagination data={requirements.requirements} count={requirements.count}>
                        <a
                            href={route('requirement_reports.print', {status, type, course, semester})}
                            className={'inline-flex items-center px-4 py-2 border border-transparent tracking-widest text-sm rounded-lg text-white transition ease-in-out duration-150 focus:ring-2 gap-2 bg-blue-500 hover:bg-blue-600 focus:ring-blue-300'}
                            target='_blank'
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16" className="h-5 w-5">
                                <g fill="currentColor">
                                    <path d="M2.5 8a.5.5 0 1 0 0-1a.5.5 0 0 0 0 1z"/>
                                    <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                                </g>
                            </svg>
                            Impressão
                        </a>
                    </Pagination>
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Index;
