import React, { useState } from "react";
import HomeLayout from "@/Layouts/HomeLayout";
import Header from "@/Components/Public/Header";
import Panel from "@/Components/Public/Panel";
import Select from "@/Components/Form/Select";
import { useForm } from "@inertiajs/react";
import Button from "@/Components/Form/Button";
import InputError from "@/Components/InputError";

export default function Enrollments({ enrollments, student, requirements }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        enrollment: null,
        requirement: null,
        weekday: ''
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? event.target.checked : event.target.value);
    };

    const submit = (e) => {
        e.preventDefault();
        setData('weekday', weekDays);
        post(route("home.requirements.post"), {
            preserveScroll: true,
            onError: () => captchaRef.current.resetCaptcha(),
            onSuccess: () => {reset()},
        });
    }

    const [weekDays, setWeekDay] = useState([]);

    const toggleWeekDay = (e) => {
        if (weekDays.includes(e.target.value))
            setWeekDay(weekDays.filter(item => item !== e.target.value))
        else
            setWeekDay([e.target.value, ...weekDays])
    }

    return (
        <HomeLayout>
            <div className="flex flex-col gap-2 md:gap-4 my-2">
                <Panel className={'flex flex-wrap justify-between gap-2'}>
                    <Header
                        title="Requerimento de Acesso ao Restaurante Acadêmico"
                        subtitle="Formulário de solicitação do cartão de acesso ao Restaurante Acadêmico do IFCE - Campus Sobral."
                    />
                </Panel>
                <Panel className={'flex flex-col flex-wrap justify-between gap-2 p-4'}>
                    <h3 className="text-xl font-semibold">Dados do requerente</h3>
                    <div className="flex flex-col gap-2">
                        <div className="flex flex-col">
                            <span className="font-light">Nome:</span>
                            <span className="text-lg">{student.name}</span>
                        </div>
                        <div className="flex flex-col">
                            <span className="font-light">C.P.F.:</span>
                            <span className="text-lg">{student.cpf}</span>
                        </div>
                        <div className="flex flex-col">
                            <span className="font-light">R.G.:</span>
                            <span className="text-lg">{student.rg}</span>
                        </div>
                        <div className="flex flex-col">
                            <span className="font-light">Data de Nascimento:</span>
                            <span className="text-lg">{student.birth}</span>
                        </div>
                    </div>
                </Panel>
                <form onSubmit={submit} className="flex flex-col gap-2 md:gap-4">
                    <Panel className={'flex flex-col flex-wrap justify-between gap-2 p-4'}>
                        <div className="">
                            <h1 className="text-xl font-semibold">Quais dias da semana que você tem aula(s):</h1>
                            {!weekDays.length && <p className='text-sm font-semibold text-red-400'>Por favor, selecionar ao menos um dia da semana para continuar sua solicitação.</p>}
                        </div>
                        <div className="grid grid-cols-2 gap-2">
                            <div className="flex flex-row items-center gap-2">
                                <input type="checkbox" name="mo" value={1} id='mo' onChange={toggleWeekDay} className='w-5 h-5 border-gray-500 rounded' />
                                <label htmlFor='mo'>Segunda-feira</label>
                            </div>
                            <div className="flex flex-row items-center gap-2">
                                <input type="checkbox" name="tu" value={2} id='tu' onChange={toggleWeekDay} className='w-5 h-5 border-gray-500 rounded' />
                                <label htmlFor='tu'>Terça-feira</label>
                            </div>
                            <div className="flex flex-row items-center gap-2">
                                <input type="checkbox" name="we" value={3} id='we' onChange={toggleWeekDay} className='w-5 h-5 border-gray-500 rounded' />
                                <label htmlFor='we'>Quarta-feira</label>
                            </div>
                            <div className="flex flex-row items-center gap-2">
                                <input type="checkbox" name="th" value={4} id='th' onChange={toggleWeekDay} className='w-5 h-5 border-gray-500 rounded' />
                                <label htmlFor='th'>Quinta-feira</label>
                            </div>
                            <div className="flex flex-row items-center gap-2">
                                <input type="checkbox" name="fr" value={5} id='fr' onChange={toggleWeekDay} className='w-5 h-5 border-gray-500 rounded' />
                                <label htmlFor='fr'>Sexta-feira</label>
                            </div>
                            <div className="flex flex-row items-center gap-2">
                                <input type="checkbox" name="sa" value={6} id='sa' onChange={toggleWeekDay} className='w-5 h-5 border-gray-500 rounded' />
                                <label htmlFor='sa'>Sábado</label>
                            </div>
                        </div>
                        <InputError message={errors.weekday} className="mt-2" />
                    </Panel>
                    <Panel className={'flex flex-col flex-wrap justify-between gap-2 p-4'}>
                        <h1 className="text-xl font-semibold">Matricula(s)</h1>
                        <div className="">
                            <span>Selecione a matricula/curso que você deseja fazer o requerimento.</span>
                            <Select
                                name={'enrollment'}
                                value={data.enrollment}
                                handleChange={onHandleChange}
                                required
                                processing={processing}
                            >
                                <option value="">Selecione uma matricula/curso</option>
                                {enrollments.map((item, i) => {
                                    return <option value={item.enrollment} key={i}>{item.course}</option>
                                })}
                            </Select>
                            {!data.enrollment && <p className='text-sm font-semibold text-red-400'>Por favor, selecionar uma matricula para continuar sua solicitação.</p>}
                            <InputError message={errors.enrollment} className="mt-2" />
                        </div>
                    </Panel>
                    <Panel className={'flex flex-col flex-wrap justify-between gap-2 p-4'}>
                        <h1 className="text-xl font-semibold">Requerimento</h1>
                        <div className="">
                            <span>Selecione o requerimento que você deseja fazer.</span>
                            <Select
                                name={'requirement'}
                                value={data.requirement}
                                handleChange={onHandleChange}
                                required
                                processing={processing}
                            >
                                <option value="">Selecione uma matricula/curso</option>
                                {requirements.map((item, i) => {
                                    return <option value={item.id} key={i}>{item.description}</option>
                                })}
                            </Select>
                            {!data.requirement && <p className='text-sm font-semibold text-red-400'>Por favor, selecionar um tipo de requerimento para continuar sua solicitação.</p>}
                            <InputError message={errors.requirement} className="mt-2" />
                        </div>
                    </Panel>
                    <Panel className={'flex flex-col flex-wrap justify-between md:justify-center md:items-center gap-2 p-4'}>
                        <Button
                            type='submit'
                            color={'green'}
                            className={'flex justify-center items-center gap-2'}
                            processing={processing || !weekDays.length || !data.enrollment || !data.requirement}
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="h-5 w-6" viewBox="0 0 16 16">
                                <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                            </svg>
                            <span>Requerer</span>
                        </Button>
                    </Panel>
                </form>
            </div>
        </HomeLayout>
    )
}
