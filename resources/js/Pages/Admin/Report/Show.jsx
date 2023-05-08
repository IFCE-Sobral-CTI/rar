import React from "react";
import { Head, Link } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Button from "@/Components/Form/Button";
import DeleteModal from "@/Components/Dashboard/DeleteModal";
import ShowField from "@/Components/Dashboard/ShowField";
import Pagination from "@/Components/Dashboard/Pagination";
import Confirmation from "@/Components/Dashboard/Confirmation";

function Show({ report, dispatches, can }) {
    const status = (status) => {
        let className = 'py-1 px-2 rounded-md text-sm text-white';
        if (status) {
            className += ' bg-green-500';
        } else {
            className += ' bg-yellow-500';
        }

        return (
            <span className={className}>{status == '1' ? 'Enviado' : 'Não enviado'}</span>
        )
    }

    const table = dispatches.dispatches.data.map((item, index) => {
        return (
            <tr key={index} className={"border-t transition hover:bg-neutral-100 " + (index % 2 == 0? 'bg-neutral-50': '')}>
                <td className="px-1 py-3 font-light">
                    <Link href={can.dispatch_view && route('requirements.dispatches.show', {dispatch: item.id, requirement: item.requirement.id})}>
                        {item.requirement.requirement_type.description}
                    </Link>
                </td>
                <td className="px-1 py-3 font-light">
                    <Link href={can.dispatch_view && route('requirements.dispatches.show', {dispatch: item.id, requirement: item.requirement.id})}>
                        {item.requirement.enrollment.number}
                    </Link>
                </td>
                <td className="px-1 py-3 font-light">
                    <Link href={can.dispatch_view && route('requirements.dispatches.show', {dispatch: item.id, requirement: item.requirement.id})}>
                        {item.requirement.enrollment.student.name}
                    </Link>
                </td>
                <td className="flex justify-end py-3 pr-2 text-neutral-400">
                    <Link href={can.dispatch_view && route('requirements.dispatches.show', {dispatch: item.id, requirement: item.requirement.id})}>
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
            <Head title="Detalhes do relatório" />
            <AuthenticatedLayout
                titleChildren={'Detalhes do relatório'}
                breadcrumbs={[
                    { label: 'Relatórios', url: route('reports.index') },
                    { label: report.id, url: route('reports.show', report.id)}
                ]}
            >
                <Panel className={'flex gap-4'}>
                    <ShowField label={'Criado em'} value={report.created_at} />
                    <ShowField label={'Criado por'} value={report.user.name} />
                    <ShowField label={'Enviado para reprografia'} value={status(report.printed)} />
                </Panel>

                <Panel>
                    <table className="w-full table-auto text-neutral-600">
                        <thead>
                            <tr className="border-b">
                                <th className="px-1 pt-3 font-semibold text-left w-2/12">Tipo</th>
                                <th className="px-1 pt-3 font-semibold text-left w-2/12">Matricula</th>
                                <th className="px-1 pt-3 font-semibold text-left w-6/12">Discente</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {table}
                        </tbody>
                    </table>
                    <Pagination data={dispatches.dispatches} count={dispatches.count} />
                </Panel>
                <Panel className={'flex flex-wrap items-center justify-center gap-1 md:gap-4'}>
                    <Button href={route('reports.index')} className={'gap-2'}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                            <path fillRule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        <span>Voltar</span>
                    </Button>
                    {(can.update && !report.printed) &&
                        <Confirmation
                            url={route('reports.update', report.id)}
                            method={'put'}
                            values={{printed: true}}
                            message={'Após a confirmação um e-mail será enviado a reprografia que fará a impressão dos cartões e esse relatório constará como impresso. Você confirma o envio para a reprografia?'}
                            textButton={'Enviar para reprografia'}
                            iconButton={<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16" className="w-5 h-5">
                                <path fill="currentColor" d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576L6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76l7.494-7.493Z"/>
                            </svg>}
                        />
                    }
                    {(can.print && !!report.printed) &&
                        <Button href={route('report.print', report.id)} className={'gap-2'} color={'blue'} target={'_blank'}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" className="h-5 w-5">
                                <path fill="currentColor" d="M16 8V5H8v3H6V3h12v5h-2ZM4 10h16H4Zm14 2.5q.425 0 .713-.288T19 11.5q0-.425-.288-.713T18 10.5q-.425 0-.713.288T17 11.5q0 .425.288.713T18 12.5ZM16 19v-4H8v4h8Zm2 2H6v-4H2v-6q0-1.275.875-2.138T5 8h14q1.275 0 2.138.863T22 11v6h-4v4Zm2-6v-4q0-.425-.288-.713T19 10H5q-.425 0-.713.288T4 11v4h2v-2h12v2h2Z"/>
                            </svg>
                            <span>Imprimir</span>
                        </Button>
                    }
                    {can.delete && <DeleteModal url={route('reports.destroy', report.id)} />}
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Show;

