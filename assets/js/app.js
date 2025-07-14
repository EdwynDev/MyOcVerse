// MyOCVerse JavaScript

// Système de notifications
class NotificationSystem {
    constructor() {
        this.container = this.createContainer();
    }
    
    createContainer() {
        const container = document.createElement('div');
        container.id = 'notification-container';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            max-width: 400px;
        `;
        document.body.appendChild(container);
        return container;
    }
    
    show(message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="flex items-center justify-between">
                <span>${message}</span>
                <button class="ml-4 text-xl" onclick="this.parentElement.parentElement.remove()">×</button>
            </div>
        `;
        
        this.container.appendChild(notification);
        
        // Animation d'entrée
        setTimeout(() => notification.classList.add('show'), 10);
        
        // Suppression automatique
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, duration);
    }
}

// Système de likes AJAX
class LikeSystem {
    constructor() {
        this.initializeLikeButtons();
    }
    
    initializeLikeButtons() {
        document.querySelectorAll('.like-button').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleLike(button);
            });
        });
    }
    
    async toggleLike(button) {
        const contentType = button.dataset.type;
        const contentId = button.dataset.id;
        
        try {
            const response = await fetch(`/${contentType}/${contentId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=like'
            });
            
            if (response.ok) {
                const data = await response.json();
                
                // Mettre à jour l'interface
                const isLiked = button.classList.toggle('liked');
                const countElement = button.querySelector('.like-count');
                
                if (countElement) {
                    let count = parseInt(countElement.textContent);
                    count += isLiked ? 1 : -1;
                    countElement.textContent = count;
                }
                
                // Animation
                button.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    button.style.transform = 'scale(1)';
                }, 200);
                
                // Notification
                notifications.show(
                    isLiked ? 'Ajouté aux favoris !' : 'Retiré des favoris',
                    'success',
                    2000
                );
            }
        } catch (error) {
            console.error('Erreur lors du like:', error);
            notifications.show('Erreur lors de l\'action', 'error');
        }
    }
}

// Système de recherche en temps réel
class SearchSystem {
    constructor() {
        this.searchInput = document.getElementById('search-input');
        this.searchResults = document.getElementById('search-results');
        this.debounceTimer = null;
        
        if (this.searchInput) {
            this.initializeSearch();
        }
    }
    
    initializeSearch() {
        this.searchInput.addEventListener('input', (e) => {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.performSearch(e.target.value);
            }, 300);
        });
    }
    
    async performSearch(query) {
        if (query.length < 2) {
            this.searchResults.innerHTML = '';
            return;
        }
        
        try {
            const response = await fetch(`/search?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            
            this.displayResults(data);
        } catch (error) {
            console.error('Erreur de recherche:', error);
        }
    }
    
    displayResults(results) {
        let html = '';
        
        results.forEach(result => {
            html += `
                <div class="search-result-item">
                    <a href="${result.url}" class="flex items-center p-3 hover:bg-gray-700 rounded">
                        <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-${result.icon}"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">${result.title}</h4>
                            <p class="text-sm text-gray-400">${result.description}</p>
                        </div>
                    </a>
                </div>
            `;
        });
        
        this.searchResults.innerHTML = html;
    }
}

// Système de modal
class ModalSystem {
    constructor() {
        this.currentModal = null;
        this.initializeModals();
    }
    
    initializeModals() {
        document.querySelectorAll('[data-modal]').forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                const modalId = trigger.dataset.modal;
                this.openModal(modalId);
            });
        });
        
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal-overlay')) {
                this.closeModal();
            }
        });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.currentModal) {
                this.closeModal();
            }
        });
    }
    
    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            this.currentModal = modal;
            document.body.style.overflow = 'hidden';
        }
    }
    
    closeModal() {
        if (this.currentModal) {
            this.currentModal.classList.add('hidden');
            this.currentModal = null;
            document.body.style.overflow = 'auto';
        }
    }
}

// Système de thème
class ThemeSystem {
    constructor() {
        this.currentTheme = localStorage.getItem('theme') || 'dark';
        this.applyTheme();
    }
    
    applyTheme() {
        document.body.classList.remove('theme-light', 'theme-dark');
        document.body.classList.add(`theme-${this.currentTheme}`);
    }
    
    toggleTheme() {
        this.currentTheme = this.currentTheme === 'dark' ? 'light' : 'dark';
        localStorage.setItem('theme', this.currentTheme);
        this.applyTheme();
    }
}

// Système de chargement progressif
class LazyLoader {
    constructor() {
        this.observer = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.loadContent(entry.target);
                    }
                });
            },
            { rootMargin: '50px' }
        );
        
        this.initializeLazyElements();
    }
    
    initializeLazyElements() {
        document.querySelectorAll('.lazy-load').forEach(element => {
            this.observer.observe(element);
        });
    }
    
    loadContent(element) {
        const src = element.dataset.src;
        if (src) {
            element.src = src;
            element.classList.remove('lazy-load');
            this.observer.unobserve(element);
        }
    }
}

// Système de validation de formulaire
class FormValidator {
    constructor() {
        this.forms = document.querySelectorAll('form[data-validate]');
        this.initializeForms();
    }
    
    initializeForms() {
        this.forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                }
            });
        });
    }
    
    validateForm(form) {
        let isValid = true;
        const inputs = form.querySelectorAll('input[required], textarea[required]');
        
        inputs.forEach(input => {
            if (!this.validateInput(input)) {
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    validateInput(input) {
        const value = input.value.trim();
        const type = input.type;
        let isValid = true;
        let errorMessage = '';
        
        // Validation de base
        if (input.required && !value) {
            isValid = false;
            errorMessage = 'Ce champ est obligatoire';
        }
        
        // Validation spécifique par type
        if (value && type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Email invalide';
            }
        }
        
        if (value && type === 'password') {
            if (value.length < 6) {
                isValid = false;
                errorMessage = 'Le mot de passe doit contenir au moins 6 caractères';
            }
        }
        
        this.displayValidationMessage(input, isValid, errorMessage);
        return isValid;
    }
    
    displayValidationMessage(input, isValid, message) {
        const existingMessage = input.parentNode.querySelector('.validation-message');
        if (existingMessage) {
            existingMessage.remove();
        }
        
        if (!isValid) {
            const messageElement = document.createElement('div');
            messageElement.className = 'validation-message text-red-400 text-sm mt-1';
            messageElement.textContent = message;
            input.parentNode.appendChild(messageElement);
            
            input.classList.add('border-red-500');
        } else {
            input.classList.remove('border-red-500');
        }
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    // Initialiser tous les systèmes
    window.notifications = new NotificationSystem();
    window.likeSystem = new LikeSystem();
    window.searchSystem = new SearchSystem();
    window.modalSystem = new ModalSystem();
    window.themeSystem = new ThemeSystem();
    window.lazyLoader = new LazyLoader();
    window.formValidator = new FormValidator();
    
    // Animations au chargement
    document.querySelectorAll('.animate-on-load').forEach((element, index) => {
        setTimeout(() => {
            element.classList.add('animate-fadeIn');
        }, index * 100);
    });
    
    // Gestion des tooltips
    document.querySelectorAll('[data-tooltip]').forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.dataset.tooltip;
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
        });
        
        element.addEventListener('mouseleave', function() {
            document.querySelectorAll('.tooltip').forEach(t => t.remove());
        });
    });
    
    // Smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});

// Utilitaires globaux
window.utils = {
    formatDate: (date) => {
        return new Date(date).toLocaleDateString('fr-FR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    },
    
    formatNumber: (number) => {
        return new Intl.NumberFormat('fr-FR').format(number);
    },
    
    truncateText: (text, maxLength) => {
        if (text.length <= maxLength) return text;
        return text.substr(0, maxLength) + '...';
    },
    
    debounce: (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
};