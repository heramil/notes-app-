<script setup>
import { ref, reactive, onMounted } from 'vue'
import axios from 'axios'

const API = import.meta.env.VITE_API_URL ?? 'http://notes-api.test'
const notes = ref([])
const form = reactive({ id: null, title: '', content: '' })
const editing = ref(false)
const loading = ref(false)
const error = ref('')

async function load() {
  loading.value = true
  try { notes.value = (await axios.get(`${API}/api/notes`)).data }
  catch { error.value = 'Failed to load notes' }
  finally { loading.value = false }
}

function resetForm(){ form.id=null; form.title=''; form.content=''; editing.value=false }

async function save() {
  if (!form.title.trim()) return
  try {
    if (editing.value) {
      await axios.put(`${API}/api/notes/${form.id}`, { title: form.title, content: form.content })
    } else {
      await axios.post(`${API}/api/notes`, { title: form.title, content: form.content })
    }
    resetForm(); await load()
  } catch { error.value = 'Save failed' }
}

function edit(n){ editing.value=true; form.id=n.id; form.title=n.title; form.content=n.content ?? '' }

async function remove(id){
  if(!confirm('Delete this note?')) return
  await axios.delete(`${API}/api/notes/${id}`); await load()
}

onMounted(load)

console.log('API =', import.meta.env.VITE_API_URL)

</script>

<template>
  <div class="max-w-2xl mx-auto p-6 space-y-6">
    <h1 class="text-2xl font-bold">Notes</h1>

    <div class="space-y-3 p-4 border rounded-2xl">
      <input v-model="form.title" placeholder="Title" class="w-full border rounded px-3 py-2" />
      <textarea v-model="form.content" rows="5" placeholder="Write your note..." class="w-full border rounded px-3 py-2"></textarea>
      <div class="flex gap-2">
        <button @click="save" class="px-4 py-2 rounded bg-black text-white">
          {{ editing ? 'Update' : 'Save' }}
        </button>
        <button v-if="editing" @click="resetForm" class="px-4 py-2 rounded border">Cancel</button>
      </div>
      <p v-if="error" class="text-red-600 text-sm">{{ error }}</p>
    </div>

    <div class="space-y-2">
      <div v-if="loading">Loading…</div>
      <div v-else-if="!notes.length" class="text-sm text-gray-500">No notes yet.</div>
      <div v-for="n in notes" :key="n.id" class="p-4 border rounded-2xl">
        <div class="flex justify-between items-center">
          <h2 class="font-semibold">{{ n.title }}</h2>
          <div class="flex gap-2">
            <button @click="edit(n)" class="px-3 py-1 rounded border">Edit</button>
            <button @click="remove(n.id)" class="px-3 py-1 rounded bg-red-600 text-white">Delete</button>
          </div>
        </div>
        <p class="mt-2 whitespace-pre-line text-sm text-gray-700">{{ n.content }}</p>
      </div>
    </div>
  </div>
</template>
