import React from "react";
import { Head } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Button from "@/Components/Form/Button";
import DeleteModal from "@/Components/Dashboard/DeleteModal";
import ShowField from "@/Components/Dashboard/ShowField";
import Status from "./Components/Status";

function Show({ requirement, can }) {
    const weekdays = (data) => {
        if (!data.length)
            return <>Nenhum dia selecionado.</>;

        return (<div>
            {data.map((weekday, i) => {
                return (<div key={i}>{weekday.description}</div>)
            })}
        </div>)
    };

    return (
        <>
            <Head title="Detalhes do requerimentos" />
            <AuthenticatedLayout
                titleChildren={'Detalhes do requerimentos'}
                breadcrumbs={[
                    { label: 'Requerimentos', url: route('requirements.index') },
                    { label: `${requirement.enrollment.number} - ${requirement.enrollment.student.name}`, url: route('requirements.show', requirement.id) }
                ]}
            >
                <Panel className={'flex gap-4'}>
                    <div className="">
                        <div className="font-light">Discente</div>
                        <div className="">{requirement.enrollment.student.name}</div>
                    </div>
                    <div className="">
                        <div className="font-light">Matricula</div>
                        <div className="">{requirement.enrollment.number}</div>
                    </div>
                    <div className="">
                        <div className="font-light">Curso</div>
                        <div className="">{requirement.enrollment.course.name}</div>
                    </div>
                </Panel>
                <Panel className={'flex flex-col gap-4'}>
                    <ShowField label={'Situação'} value={<Status value={requirement.status} />} />
                    <ShowField label={'Tipo de requerimento'} value={requirement.requirement_type.description} />
                    <ShowField label={'Justificativa'} value={requirement.justification?? ''} />
                    <ShowField label={'Dias de aulas'} value={weekdays(requirement.weekdays)} />
                    <ShowField label={'Semestre'} value={requirement.semester.description} />
                    <ShowField label={'Criado em'} value={requirement.created_at} />
                    <ShowField label={'Atualizado em'} value={requirement.updated_at} />
                </Panel>
                <Panel className={'flex flex-wrap items-center justify-center gap-1 md:gap-4'}>
                    <Button href={route('requirements.index')} className={'gap-2'}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                            <path fillRule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        <span>Voltar</span>
                    </Button>
                    {can.update && <Button href={route('requirements.dispatches.index', requirement.id)} className={'gap-2'} color={'sky'}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="h-5 w-5" viewBox="0 0 16 16">
                            <path d="M1 3.5A1.5 1.5 0 0 1 2.5 2h2.764c.958 0 1.76.56 2.311 1.184C7.985 3.648 8.48 4 9 4h4.5A1.5 1.5 0 0 1 15 5.5v.64c.57.265.94.876.856 1.546l-.64 5.124A2.5 2.5 0 0 1 12.733 15H3.266a2.5 2.5 0 0 1-2.481-2.19l-.64-5.124A1.5 1.5 0 0 1 1 6.14V3.5zM2 6h12v-.5a.5.5 0 0 0-.5-.5H9c-.964 0-1.71-.629-2.174-1.154C6.374 3.334 5.82 3 5.264 3H2.5a.5.5 0 0 0-.5.5V6zm-.367 1a.5.5 0 0 0-.496.562l.64 5.124A1.5 1.5 0 0 0 3.266 14h9.468a1.5 1.5 0 0 0 1.489-1.314l.64-5.124A.5.5 0 0 0 14.367 7H1.633z"/>
                        </svg>
                        <span>Despachos</span>
                    </Button>}
                    {can.update && <Button href={route('requirements.edit', requirement.id)} className={'gap-2'} color={'yellow'}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                        </svg>
                        <span>Editar</span>
                    </Button>}
                    {can.delete && <DeleteModal url={route('requirements.destroy', requirement.id)} />}
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Show;

