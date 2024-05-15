document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    console.log(window.location.pathname)

        document.querySelectorAll('a').forEach(link => {
            const div = link.querySelector('div');
            if (div) {
                // Remove the classes initially
                div.classList.remove('bg-blue-50', 'text-blue-600');

                // Check if the href matches the current path
                const href = link.getAttribute('href');
                if (href && currentPath.includes(href)) {
                    // Add the classes if the href matches the current path
                    div.classList.add('bg-blue-50', 'text-blue-600');
                }
            }
        });
})
