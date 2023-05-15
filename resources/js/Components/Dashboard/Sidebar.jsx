import {
    Collapse,
    Ripple,
    initTE,
} from "tw-elements";

import { Link } from "@inertiajs/react";
import React, { useEffect, useState } from "react";

function Sidebar({ can }) {
    const [width, setWidth] = useState(window.innerWidth);

    const [accessCollapse] = useState(
        route().current('users.*') ||
        route().current('permissions.*') ||
        route().current('rules.*') ||
        route().current('groups.*') ||
        route().current('activities.*')
    );

    const [schoolCollapse] = useState(
        route().current('weekdays.*') ||
        route().current('students.*') ||
        route().current('courses.*') ||
        route().current('course_types.*') ||
        route().current('semesters.*')
    );

    const [requirementsCollapse] = useState(
        route().current('requirements.*') ||
        route().current('types.*')
    );

    const [printQueueCollapse] = useState(
        route().current('print_queues.*') ||
        route().current('reports.*')
    );

    const [chevronSchool, setChevronSchool] = useState(schoolCollapse);
    const [chevronAccess, setChevronAccess] = useState(accessCollapse);
    const [chevronRequirement, setChevronRequirement] = useState(requirementsCollapse);
    const [chevronPrintQueue, setChevronPrintQueue] = useState(printQueueCollapse);

    const toggleChevronSchool = () => {
        setChevronSchool(!chevronSchool);
    }

    const toggleChevronAccess = () => {
        setChevronAccess(!chevronAccess);
    }

    const toggleChevronRequirement = () => {
        setChevronRequirement(!chevronRequirement);
    }

    const toggleChevronPrintQueue = () => {
        setChevronPrintQueue(!chevronPrintQueue);
    }

    useEffect(() => {
        initTE({ Collapse, Ripple });
    });

    useEffect(() => {
        setWidth(window.innerWidth);
    }, [window.innerWidth]);

    return (
        <>
            <nav id="sidebar" className={"!visible mr-2 p-2 " + (width >= 1024? '': 'hidden')} data-te-collapse-item data-te-collapse-horizontal>
                <div className="flex flex-col w-48 gap-3 md:w-64">
                    <Link
                        href={route('admin')}
                        className={((route().current('admin'))? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-2 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                            <path fillRule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                            <path fillRule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                        </svg>
                        Principal
                    </Link>

                    {(can.students_viewAny || can.courses_viewAny || can.weekdays_viewAny || can.semesters_viewAny || can.course_types_viewAny) && <>
                        <button
                            className={
                                (
                                    schoolCollapse
                                    ? 'bg-gray-50 shadow-md '
                                    : ''
                                ) + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex items-center gap-4 focus:ring-0`}
                            type="button"

                            data-te-collapse-init
                            data-te-target="#schoolCollapse"
                            aria-controls="schoolCollapse"
                            aria-expanded="false"
                            onClick={toggleChevronSchool}
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512" className="h-5 w-5">
                                <path fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="28" d="M32 192L256 64l224 128l-224 128L32 192z"/>
                                <path fill="none" stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="28" d="M112 240v128l144 80l144-80V240m80 128V192M256 320v128"/>
                            </svg>
                            Ensino
                            <span className={"flex-1 flex justify-end "}>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    className={"h-5 w-5 transition " + (!chevronSchool? ' -rotate-90': '')}
                                    viewBox="0 0 16 16"
                                >
                                    <path fillRule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </button>
                        <div
                            className={'flex flex-col gap-1 pl-2 transition bg-neutral-200 rounded-md p-2 shadow-md !visible ' + (chevronSchool? '': 'hidden')}
                            data-te-collapse-item
                            id="schoolCollapse"
                        >
                            {(can.students_viewAny && can.enrollments_viewAny) && <Link
                                href={route('students.index', {term: '', page: 1})}
                                className={(route().current('students.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 256 256" className="w-5 h-5">
                                    <path fill="currentColor" d="m226.53 56.41l-96-32a8 8 0 0 0-5.06 0l-96 32A8 8 0 0 0 24 64v80a8 8 0 0 0 16 0V75.1l33.59 11.19a64 64 0 0 0 20.65 88.05c-18 7.06-33.56 19.83-44.94 37.29a8 8 0 1 0 13.4 8.74C77.77 197.25 101.57 184 128 184s50.23 13.25 65.3 36.37a8 8 0 0 0 13.4-8.74c-11.38-17.46-27-30.23-44.94-37.29a64 64 0 0 0 20.65-88l44.12-14.7a8 8 0 0 0 0-15.18ZM176 120a48 48 0 1 1-86.65-28.45l36.12 12a8 8 0 0 0 5.06 0l36.12-12A47.89 47.89 0 0 1 176 120Zm-48-32.43L57.3 64L128 40.43L198.7 64Z"/>
                                </svg>
                                Discentes
                            </Link>}
                            {can.courses_viewAny && <Link
                                href={route('courses.index', {term: '', page: 1})}
                                className={(route().current('courses.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                                    <path fillRule="evenodd" d="M6 8V1h1v6.117L8.743 6.07a.5.5 0 0 1 .514 0L11 7.117V1h1v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                                </svg>
                                Cursos
                            </Link>}
                            {can.course_types_viewAny && <Link
                                href={route('course_types.index', {term: '', page: 1})}
                                className={(route().current('course_types.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512" className="h-5 w-5">
                                    <path fill="none" stroke="currentColor" strokeLinejoin="round" strokeWidth="32" d="M48 336v96a48.14 48.14 0 0 0 48 48h320a48.14 48.14 0 0 0 48-48v-96"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M48 336h144m128 0h144m-272 0a64 64 0 0 0 128 0"/><path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" d="M384 32H128c-26 0-43 14-48 40L48 192v96a48.14 48.14 0 0 0 48 48h320a48.14 48.14 0 0 0 48-48v-96L432 72c-5-27-23-40-48-40Z"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M48 192h144m128 0h144m-272 0a64 64 0 0 0 128 0"/>
                                </svg>
                                Tipos de Cursos
                            </Link>}
                            {can.weekdays_viewAny && <Link
                                href={route('weekdays.index', {term: '', page: 1})}
                                className={(route().current('weekdays.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                                    <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z"/>
                                    <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4z"/>
                                </svg>
                                Dias da semana
                            </Link>}
                            {can.semesters_viewAny && <Link
                                href={route('semesters.index', {term: '', page: 1})}
                                className={(route().current('semesters.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="h-5 w-5" viewBox="0 0 16 16">
                                    <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z"/>
                                    <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                </svg>
                                Semestres
                            </Link>}
                        </div>
                    </>}


                    {(can.requirements_viewAny || can.types_viewAny) && <>
                        <button
                            className={
                                (
                                    requirementsCollapse
                                    ? 'bg-gray-50 shadow-md '
                                    : ''
                                ) + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex items-center gap-4 focus:ring-0`}
                            type="button"

                            data-te-collapse-init
                            data-te-target="#requirementCollapse"
                            aria-controls="requirementCollapse"
                            aria-expanded="false"
                            onClick={toggleChevronRequirement}
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="h-5 w-5" viewBox="0 0 16 16">
                                <path d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2 2 2 0 0 1-2 2H3a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1H1a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2z"/>
                                <path d="M1 6v-.5a.5.5 0 0 1 1 0V6h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V9h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 2.5v.5H.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1H2v-.5a.5.5 0 0 0-1 0z"/>
                            </svg>
                            Requerimentos
                            <span className={"flex-1 flex justify-end "}>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    className={"h-5 w-5 transition " + (!chevronRequirement? ' -rotate-90': '')}
                                    viewBox="0 0 16 16"
                                >
                                    <path fillRule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </button>
                        <div
                            className={'flex flex-col gap-1 pl-2 transition bg-neutral-200 rounded-md p-2 shadow-md !visible ' + (chevronRequirement? '': 'hidden')}
                            data-te-collapse-item
                            id="requirementCollapse"
                        >
                            {can.requirements_viewAny && <Link
                                href={route('requirements.index', {term: '', page: 1})}
                                className={(route().current('requirements.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="h-5 w-5" viewBox="0 0 16 16">
                                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                                </svg>
                                Requerimentos
                            </Link>}
                            {can.types_viewAny && <Link
                                href={route('types.index', {term: '', page: 1})}
                                className={(route().current('types.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="h-5 w-5" viewBox="0 0 16 16">
                                    <path fillRule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                </svg>
                                Tipos de Requerimento
                            </Link>}
                        </div>
                    </>}


                    {(can.print_queues_viewAny || reports_viewAny) && <>
                        <button
                            className={
                                (
                                    printQueueCollapse
                                    ? 'bg-gray-50 shadow-md '
                                    : ''
                                ) + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex items-center gap-4 focus:ring-0`}
                            type="button"
                            data-te-collapse-init
                            data-te-target="#printQueueCollapse"
                            aria-controls="printQueueCollapse"
                            aria-expanded="false"
                            onClick={toggleChevronPrintQueue}
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="h-5 w-5" viewBox="0 0 16 16">
                                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                            </svg>
                            Impressões
                            <span className={"flex-1 flex justify-end "}>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    className={"h-5 w-5 transition " + (!chevronPrintQueue? ' -rotate-90': '')}
                                    viewBox="0 0 16 16"
                                >
                                    <path fillRule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </button>
                        <div
                            className={'flex flex-col gap-1  transition bg-neutral-200 rounded-md p-2 shadow-md !visible ' + (chevronPrintQueue? '': 'hidden')}
                            data-te-collapse-item
                            id="printQueueCollapse"
                        >
                            {can.print_queues_viewAny && <Link
                                href={route('print_queues.index', {term: '', page: 1})}
                                className={(route().current('print_queues.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="h-5 w-5" viewBox="0 0 16 16">
                                    <path d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-11zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1h-7zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6v7zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13z"/>
                                </svg>
                                Fila de impressão
                            </Link>}
                            {can.reports_viewAny && <Link
                                href={route('reports.index', {term: '', page: 1})}
                                className={(route().current('reports.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="h-5 w-5" viewBox="0 0 16 16">
                                    <path d="M4 11a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1zm6-4a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V7zM7 9a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0V9z"/>
                                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                                    <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                                </svg>
                                Relatórios
                            </Link>}
                        </div>
                    </>}


                    {(can.users_viewAny || can.permissions_viewAny || can.rules_viewAny || can.groups_viewAny || can.activities_viewAny) && <>
                        <button
                            className={
                                (
                                    accessCollapse
                                    ? 'bg-gray-50 shadow-md '
                                    : ''
                                ) + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex items-center gap-4 focus:ring-0`}
                            type="button"

                            data-te-collapse-init
                            data-te-target="#accessCollapse"
                            aria-controls="accessCollapse"
                            aria-expanded="false"
                            onClick={toggleChevronAccess}
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                            </svg>
                            Acesso
                            <span className={"flex-1 flex justify-end "}>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    className={"h-5 w-5 transition " + (!chevronAccess? ' -rotate-90': '')}
                                    viewBox="0 0 16 16"
                                >
                                    <path fillRule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </span>
                        </button>
                        <div
                            className={'flex flex-col gap-1 pl-2 transition bg-neutral-200 rounded-md p-2 shadow-md !visible ' + (chevronAccess? '': 'hidden')}
                            data-te-collapse-item
                            id="accessCollapse"
                        >
                            {can.users_viewAny && <Link
                                href={route('users.index', {term: '', page: 1})}
                                className={(route().current('users.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                </svg>
                                Usuários
                            </Link>}
                            {can.groups_viewAny && <Link
                                href={route('groups.index', {term: '', page: 1})}
                                className={(route().current('groups.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                                    <path d="M0 4s0-2 2-2h12s2 0 2 2v6s0 2-2 2h-4c0 .667.083 1.167.25 1.5H11a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1h.75c.167-.333.25-.833.25-1.5H2s-2 0-2-2V4zm1.398-.855a.758.758 0 0 0-.254.302A1.46 1.46 0 0 0 1 4.01V10c0 .325.078.502.145.602.07.105.17.188.302.254a1.464 1.464 0 0 0 .538.143L2.01 11H14c.325 0 .502-.078.602-.145a.758.758 0 0 0 .254-.302 1.464 1.464 0 0 0 .143-.538L15 9.99V4c0-.325-.078-.502-.145-.602a.757.757 0 0 0-.302-.254A1.46 1.46 0 0 0 13.99 3H2c-.325 0-.502.078-.602.145z"/>
                                </svg>
                                Páginas
                            </Link>}
                            {can.permissions_viewAny && <Link
                                href={route('permissions.index', {term: '', page: 1})}
                                className={(route().current('permissions.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                                    <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H4Zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                    <path d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2H2Z"/>
                                </svg>
                                Permissões
                            </Link>}
                            {can.rules_viewAny && <Link
                                href={route('rules.index', {term: '', page: 1})}
                                className={(route().current('rules.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                                    <path d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5V4zm2-1a1 1 0 0 0-1 1v10.566l3.723-2.482a.5.5 0 0 1 .554 0L11 14.566V4a1 1 0 0 0-1-1H4z"/>
                                    <path d="M4.268 1H12a1 1 0 0 1 1 1v11.768l.223.148A.5.5 0 0 0 14 13.5V2a2 2 0 0 0-2-2H6a2 2 0 0 0-1.732 1z"/>
                                </svg>
                                Regras
                            </Link>}
                            {can.activities_viewAny && <Link
                                href={route('activities.index', {term: '', page: 1})}
                                className={(route().current('activities.*')? 'bg-gray-50 shadow-md ': '') + `text-gray-600 p-3 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                                    <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                    <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                </svg>
                            Logs
                        </Link>}
                        </div>
                    </>}
                    {(can.faqs_viewAny) &&
                        <div>
                            <Link
                                href={route('faqs.index')}
                                className={((route().current('faqs.*'))? 'bg-gray-50 shadow-md ': '') + `text-gray-600 px-3 py-2 rounded-lg hover:bg-white hover:shadow-md transition flex gap-4 items-center`}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                                </svg>
                                <span>FAQ</span>
                            </Link>
                        </div>
                    }
                </div>
            </nav>
        </>
    )
}

export default Sidebar;
