import React, { useEffect } from 'react';
import Panel from '@/Components/Dashboard/Panel';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {
    Chart as ChartJS,
    ArcElement,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from 'chart.js';
import { Bar, Doughnut, Line } from 'react-chartjs-2';
import { Link } from '@inertiajs/react';

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    PointElement,
    LineElement,
    ArcElement,
    Title,
    Tooltip,
    Legend
);

export default function Dashboard({ print_queue, print, can, semester, requirements, dispatches }) {
    console.log(requirements.renovationsChart)
    return (
        <>
            <AuthenticatedLayout breadcrumbs={[{label: 'Dashboard', url: route('admin')}]}>
                <Panel className="">
                    <div className="flex justify-between flex-wrap gap-4">
                        <div className="flex flex-col flex-1 items-center justify-center bg-lime-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Renovação</h3>
                            <p className="font-extrabold text-4xl">{requirements.renovations}</p>
                        </div>
                        <div className="flex flex-col flex-1 items-center justify-center bg-emerald-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Primeira via</h3>
                            <p className="font-extrabold text-4xl">{requirements.first_copy}</p>
                        </div>
                        <div className="flex flex-col flex-1 items-center justify-center bg-cyan-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Segunda via</h3>
                            <p className="font-extrabold text-4xl">{requirements.reprint}</p>
                        </div>
                        <div className="flex flex-col flex-1 items-center justify-center bg-blue-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Requerimentos</h3>
                            <p className="font-extrabold text-4xl">{requirements.count}</p>
                        </div>
                        <div className="flex flex-col flex-1 items-center justify-center bg-violet-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Despachos</h3>
                            <p className="font-extrabold text-4xl">{dispatches.count}</p>
                        </div>
                    </div>
                </Panel>
                <div className="grid grid-cols-2 grid-rows-2 gap-4">
                    <Panel>
                        <h2 className="text-xl font-semibold text-neutral-500">Requerimentos de renovação</h2>
                        <Bar
                            options={{
                                responsive: true,
                            }}
                            data={requirements.renovations_chart}
                        />
                    </Panel>
                    <Panel>
                        <h2 className="text-xl font-semibold text-neutral-500">Requerimentos de primeira via</h2>
                        <Line
                            options={{
                                responsive: true,
                            }}
                            data={requirements.first_copy_chart}
                        />
                    </Panel>
                    <Panel>
                        <h2 className="text-xl font-semibold text-neutral-500">Requerimentos de segunda via</h2>
                        <Line
                            options={{
                                responsive: true,
                            }}
                            data={requirements.reprint_chart}
                        />
                    </Panel>
                    <Panel>
                        <h2 className="text-xl font-semibold text-neutral-500">Relatório de Impressões</h2>
                        <Bar
                            options={{
                                indexAxis: 'y',
                                elements: {
                                    bar: {
                                        borderWidth: 2,
                                    },
                                },
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Impressões',
                                    },
                                },
                            }}
                            data={print.chart}
                        />
                    </Panel>
                </div>
                <div className="grid grid-cols-5 grid-rows-1 gap-4">
                    <Panel className="col-span-2 h-96 flex justify-center items-center">
                        <Doughnut
                            options={{
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Tipos de cursos',
                                    },
                                },
                            }}
                            data={requirements.courses}
                        />
                    </Panel>
                    <Panel className="col-span-2 h-96 flex justify-center items-center">
                        <Doughnut
                            options={{
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Situação dos requerimentos',
                                    },
                                },
                            }}
                            data={dispatches.chart}
                        />
                    </Panel>
                    <Panel className="col-span-1 flex flex-col gap-4">
                        <div className="flex flex-col flex-1 items-center justify-center bg-yellow-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Fila de Impressão</h3>
                            <p className="font-extrabold text-4xl">{print_queue.count}</p>
                        </div>
                        <div className="flex flex-col flex-1 items-center justify-center bg-blue-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase">Impressões</h3>
                            <p className="font-extrabold text-4xl">{print.count}</p>
                        </div>
                        <div className="flex flex-col flex-1 items-center justify-center bg-green-500 text-white p-2 rounded-md shadow-md">
                            <h3 className="font-light uppercase text-center">Relatórios enviado a reprografia</h3>
                            <p className="font-extrabold text-4xl">{print.printed}</p>
                        </div>
                    </Panel>
                </div>
                <Panel className="col-span-6">
                    <h2 className="text-xl font-semibold text-neutral-500">5 últimos registro da fila de impressão</h2>
                    <table className="w-full table-auto text-neutral-600">
                        <thead>
                            <tr className="border-b">
                                <th className="px-1 pt-3 font-semibold text-left w-2/12">Requerimento</th>
                                <th className="px-1 pt-3 font-semibold text-left w-2/12">Matricula</th>
                                <th className="px-1 pt-3 font-semibold text-left w-7/12">Discente</th>
                                <th className="w-1/12"></th>
                            </tr>
                        </thead>
                        <tbody>
                            {print_queue.list.map((item, index) => {
                                return (
                                    <tr key={index} className={"border-t transition hover:bg-neutral-100 " + (index % 2 == 0? 'bg-neutral-50': '')}>
                                        <td className="px-1 py-3 font-light">
                                            <Link href={can.print_queue_view? route('print_queues.index'): route('admin')}>
                                                {item.dispatch.requirement.requirement_type.description}
                                            </Link>
                                        </td>
                                        <td className="px-1 py-3 font-light">
                                            <Link href={can.print_queue_view? route('print_queues.index'): route('admin')}>
                                                {item.dispatch.requirement.enrollment.number}
                                            </Link>
                                        </td>
                                        <td className="px-1 py-3 font-light">
                                            <Link href={can.print_queue_view? route('print_queues.index'): route('admin')}>
                                                {item.dispatch.requirement.enrollment.student.name}
                                            </Link>
                                        </td>
                                        <td className="flex justify-end py-3 pr-2 text-neutral-400">
                                            <Link href={can.print_queue_view? route('print_queues.index'): route('admin')}>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                                                    <path fillRule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                                                </svg>
                                            </Link>
                                        </td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>
                </Panel>
                <div className="text-right text-sm font-light">Dados referentes ao semestre: <strong className="font-bold text-neutral-600">{semester.description}</strong></div>
            </AuthenticatedLayout>
        </>
    )
}
