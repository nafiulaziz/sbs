<template>
  <div class="min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
      <div class="max-w-7xl mx-auto px-4 py-20">
        <div class="text-center">
          <h1 class="text-5xl font-bold mb-6">Professional Services at Your Fingertips</h1>
          <p class="text-xl mb-8 max-w-2xl mx-auto">
            Book high-quality services from verified professionals. Easy, fast, and reliable.
          </p>
          <div class="space-x-4">
            <button 
              v-if="!authStore.isAuthenticated"
              @click="showAuthModal = true"
              class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition"
            >
              Get Started
            </button>
            <a 
              href="/services"
              class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition inline-block"
            >
              Browse Services
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Our Platform?</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">
            We connect you with the best service providers in your area
          </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Verified Professionals</h3>
            <p class="text-gray-600">All service providers are thoroughly vetted and verified</p>
          </div>
          
          <div class="text-center">
            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Easy Booking</h3>
            <p class="text-gray-600">Book services in just a few clicks with our simple interface</p>
          </div>
          
          <div class="text-center">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">24/7 Support</h3>
            <p class="text-gray-600">Get help whenever you need it with our dedicated support team</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Featured Services -->
    <div class="py-16 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Services</h2>
        </div>
        
        <div v-if="serviceStore.loading" class="text-center">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
        </div>
        
        <div v-else class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div 
            v-for="service in featuredServices" 
            :key="service.id"
            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition"
          >
            <div class="p-6">
              <h3 class="text-xl font-semibold mb-2">{{ service.name }}</h3>
              <p class="text-gray-600 mb-4">{{ service.description }}</p>
              <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-blue-600">${{ service.price }}</span>
                <span class="text-sm text-gray-500">{{ service.duration_minutes }} min</span>
              </div>
            </div>
          </div>
        </div>
        
        <div class="text-center mt-8">
          <a 
            href="/services"
            class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition inline-block"
          >
            View All Services
          </a>
        </div>
      </div>
    </div>

    <!-- Auth Modal -->
    <auth-modal v-if="showAuthModal" @close="showAuthModal = false"></auth-modal>
  </div>
</template>

<script lang="ts">
import { ref, onMounted, computed } from 'vue';
import { useAuthStore } from '../stores/auth';
import { useServiceStore } from '../stores/services';
import AuthModal from './common/AuthModal.vue';

export default {
  name: 'HomePage',
  components: {
    AuthModal,
  },
  setup() {
    const authStore = useAuthStore();
    const serviceStore = useServiceStore();
    const showAuthModal = ref(false);

    const featuredServices = computed(() => {
      return serviceStore.activeServices.slice(0, 6);
    });

    onMounted(async () => {
      try {
        await serviceStore.fetchServices();
      } catch (error) {
        console.error('Failed to fetch services:', error);
      }
    });

    return {
      authStore,
      serviceStore,
      showAuthModal,
      featuredServices,
    };
  },
};
</script>