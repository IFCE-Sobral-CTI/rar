import React from "react";
import { Head, useForm } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import Panel from "@/Components/Dashboard/Panel";
import Form from "./Components/Form";

function Create() {
    const { data, setData, post, processing, errors } = useForm({
        description: '',
        status: '',
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('weekdays.store'), {data});
    };

    return (
        <>
            <Head title="Novo dia da semana" />
            <AuthenticatedLayout titleChildren={'Cadastro de novo dia da semana'} breadcrumbs={[{ label: 'Dias da semana', url: route('weekdays.index') }, { label: 'Novo', url: route('weekdays.create') }]}>
                <Panel className={'flex-1'}>
                    <Form data={data} errors={errors} processing={processing} onHandleChange={onHandleChange} handleSubmit={handleSubmit} />
                </Panel>
            </AuthenticatedLayout>
        </>
    )
}

export default Create;

