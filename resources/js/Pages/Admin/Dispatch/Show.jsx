import React from "react";
import { Head } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Button from "@/Components/Form/Button";
import DeleteModal from "@/Components/Dashboard/DeleteModal";
import ShowField from "@/Components/Dashboard/ShowField";

function Show({ requirement, dispatch, can }) {
    const status = (status) => {
        let className = 'py-1 px-2 rounded-md text-sm text-white';
        if (status == 2) {
            className += ' bg-green-500';
        } else {
            className += ' bg-red-500';
        }

        return (
            <span className={className}>{status == '2' ? 'Deferido' : 'Indeferido'}</span>
        )
    }
    return (
        <>
            <Head title="Detalhes do despacho" />
            <AuthenticatedLayout
                titleChildren={'Detalhes do despacho'}
                breadcrumbs={[
                    { label: 'Requerimentos', url: route('requirements.index') },
                    { label: `${requirement.enrollment.number} - ${requirement.enrollment.student.name}`, url: route('requirements.show', requirement.id) },
                    { label: 'Despachos', url: route('requirements.dispatches.index', requirement.id) },
                    { label: `${dispatch.id}`, url: route('requirements.dispatches.show', { dispatch: dispatch.id, requirement: requirement.id }) }
                ]}>
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
                    <ShowField label={'Situação'} value={status(dispatch.status)} />
                    <ShowField label={'Despacho'} value={dispatch.text} />
                    <ShowField label={'Observações'} value={dispatch.observation} />
                    <ShowField label={'Autor do despacho'} value={dispatch.user.name} />
                    <ShowField label={'Criado em'} value={dispatch.created_at} />
                    <ShowField label={'Atualizado em'} value={dispatch.updated_at} />
                </Panel>
                <Panel className={'flex flex-wrap items-center justify-center gap-1 md:gap-4'}>
                    <Button href={route('requirements.dispatches.index', requirement.id)} className={'gap-2'}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                            <path fillRule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                        <span>Voltar</span>
                    </Button>
                    {can.update && <Button href={route('requirements.dispatches.edit', { dispatch: dispatch.id, requirement: requirement.id })} className={'gap-2'} color={'yellow'}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                        </svg>
                        <span>Editar</span>
                    </Button>}
                    {can.delete && <DeleteModal url={route('requirements.dispatches.destroy', {dispatch: dispatch.id, requirement: requirement.id})} />}
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Show;

