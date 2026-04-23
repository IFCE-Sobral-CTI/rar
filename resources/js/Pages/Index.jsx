import React from 'react';
import Panel from '@/Components/Public/Panel';
import Header from '@/Components/Public/Header';
import Button from '@/Components/Form/Button';
import Input from '@/Components/Form/Input';
import HomeLayout from '@/Layouts/HomeLayout';
import InputError from '@/Components/InputError';
import { useForm } from '@inertiajs/react';

export default function Index({semester}) {
    const { data, setData, post, processing, errors, reset } = useForm({
        cpf: '',
        rg: '',
        birth: '',
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? event.target.checked : event.target.value);
    };

    const submit = (e) => {
        e.preventDefault();
        post(route("home.enrollments.post"), {
            preserveScroll: true,
            onSuccess: () => reset(),
        });
    };

    if (!semester) {
        return (
            <HomeLayout>
                <div className="flex flex-col gap-4">
                    <Panel className={'flex flex-wrap justify-between gap-2'}>
                        <Header
                            title="Requerimento de Acesso ao Restaurante Acadêmico"
                        />
                    </Panel>
                    <Panel className={'flex flex-col flex-wrap justify-between gap-2'}>
                        <h3 className='text-2xl font-semibold text-center text-red-500'>
                            Fora do período de solicitação de cartão de acesso ao restaurante.
                        </h3>
                    </Panel>
                </div>
            </HomeLayout>
        )
    }

    return (
        <>
            <HomeLayout>
                <div className="flex flex-col gap-4">
                    <Panel className={'flex flex-wrap justify-between gap-2'}>
                        <Header
                            title="Requerimento de Acesso ao Restaurante Acadêmico"
                            subtitle="Formulário de solicitação do cartão de acesso ao Restaurante Acadêmico do IFCE - Campus Sobral."
                        />
                    </Panel>
                    <form onSubmit={submit}>
                        <Panel className={'py-4 px-3 mt-2 flex flex-col gap-4'}>
                            <div className="w-full">
                                <label htmlFor={'cpf'}>C.P.F.</label>
                                <Input
                                    name={'cpf'}
                                    value={data.cpf}
                                    placeholder={'000.000.000-00'}
                                    mask={'000.000.000-00'}
                                    handleChange={onHandleChange}
                                    isFocused
                                    autofocus
                                    required
                                    className={'w-full'}
                                    processing={processing}
                                />
                                <InputError message={errors.cpf} className="mt-2" />
                            </div>
                            <div className="">
                                <label htmlFor="birth">Data de Nascimento</label>
                                <Input
                                    name={'birth'}
                                    type={'date'}
                                    value={data.birth}
                                    placeholder={'dd/mm/aaaa'}
                                    className={'w-full'}
                                    handleChange={onHandleChange}
                                    required
                                    processing={processing}
                                />
                            </div>
                            <div className="">
                                <label htmlFor="rg">R.G. <small>(Identidade)</small></label>
                                <Input
                                    name={'rg'}
                                    type={'number'}
                                    value={data.rg}
                                    placeholder={'Números do R.G.'}
                                    className={'w-full'}
                                    handleChange={onHandleChange}
                                    required
                                    processing={processing}
                                />
                            </div>
                        </Panel>
                        <Panel className={'mt-2 flex justify-center items-center gap-2'}>
                            <Button
                                type='submit'
                                color={'green'}
                                className={'flex justify-center items-center gap-2'}
                                processing={processing}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="w-5 h-5" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                </svg>
                                <span>Pesquisar</span>
                            </Button>
                        </Panel>
                    </form>
                </div>
            </HomeLayout>
        </>
    );
}
