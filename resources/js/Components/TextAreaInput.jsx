import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function TextAreaInput({  children, className = '', isFocused = false, ...props }, ref) {
    // Crea un riferimento all'elemento input
    const input = ref ? ref : useRef();

    // Effetto che controlla se l'input deve essere focalizzato quando il componente viene montato
    useEffect(() => {
        if (isFocused) {
            input.current.focus(); // Se isFocused è true, imposta lo stato di focus sull'input
        }
    }, []);

    return (
        // Restituisce l'elemento input HTML
        <textarea
            {...props} // Passa eventuali altre props all'input

            className={
                // Aggiunge classi CSS all'input per lo stile
                'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm ' +
                className // Aggiunge classi CSS personalizzate specificate come prop
            }
            ref={input} // Passa il riferimento all'elemento input
        >{children}</textarea>
    );
});
