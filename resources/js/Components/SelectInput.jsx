import { forwardRef, useRef } from 'react'; // Import delle funzioni necessarie
// useEffect,

// Definizione del componente SelectInput con la possibilità di inoltrare il riferimento
export default forwardRef(function SelectInput({ className = '', children, ...props }, ref) {//isFocused = false,
    // Creazione di un riferimento per l'elemento select
    const input = ref ? ref : useRef();

    // Effetto collaterale per il focus sull'elemento select
    // useEffect(() => {
    //     if (isFocused) {
    //         input.current.focus();
    //     }
    // }, []);

    // Ritorno del componente select con le proprietà e i figli passati
    return (
        <select
            // Proprietà aggiuntive passate al componente select
            {...props}
            // Classi CSS del componente select, con stili per lo stato di focus e non
            className={
                'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm ' +
                className
            }
            // Inoltro del riferimento all'elemento select
            ref={input}
        >
            {/* Figli del componente select, di solito le opzioni */}
            {children}
        </select>
    );
});
