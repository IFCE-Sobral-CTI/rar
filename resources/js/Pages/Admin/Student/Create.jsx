import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Create() {
    const { data, setData, post, processing, errors } = useForm({
        cpf: '',
        rg: '',
        name: '',
        birth: '',
        personal_email: '',
        institutional_email: '',
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('students.store'), {data});
    };

    return (
        <>
            <Head title="Novo(a) aluno(a)" />
            <AuthenticatedLayout titleChildren={'Cadastro de novo(a) aluno(a)'} breadcrumbs={[{ label: 'Alunos(as)', url: route('students.index') }, { label: 'Novo(a)', url: route('students.create') }]}>
                <Panel className={'flex-1'}>
                    <Form data={data} errors={errors} processing={processing} onHandleChange={onHandleChange} handleSubmit={handleSubmit} />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Create;

