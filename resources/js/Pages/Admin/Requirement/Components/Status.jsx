 import React from "react";

 export default function Status({value}) {
    let className = 'py-1 px-2 rounded-md text-sm text-white';
    let text;

    switch (value) {
        case 1:
            className += ' bg-yellow-500';
            text = 'Para analise';
            break;
        case 2:
            className += ' bg-green-500';
            text = 'Deferido';
            break;
        case 3:
            className += ' bg-red-500';
            text = 'Indeferido';
            break;
        default:
            className += ' bg-neutral-500';
            text = 'Indefinida';
    }

    return (
        <span className={className}>{text}</span>
    )
};
