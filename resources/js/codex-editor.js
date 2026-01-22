import EditorJS from "@editorjs/editorjs";
import Header from "@editorjs/header";
import Quote from "@editorjs/quote";
import Image from "@editorjs/image";
import EditorjsList from "@editorjs/list";

const editorElement = document.getElementById("editorjs");
const uploadUrl = document.getElementById("editorjs").dataset.uploadUrl;
const initialData = editorElement?.dataset.initial
    ? JSON.parse(editorElement.dataset.initial)
    : null;

const editor = new EditorJS({
    holder: "editorjs",
    data: initialData,
    placeholder: "Klik di sini untuk mulai menulis detail kegiatan..",
    tools: {
        header: {
            class: Header,
            shortcut: "CMD+SHIFT+H",
            inlineToolbar: ["link"],
            config: {
                placeholder: "Enter a header",
                levels: [1, 2, 3, 4],
                defaultLevel: 1,
            },
        },
        list: {
            class: EditorjsList,
            inlineToolbar: true,
            config: {
                defaultStyle: "unordered",
            },
        },
        quote: {
            class: Quote,
            inlineToolbar: true,
            config: {
                alignment: "left",
            },
        },
        image: {
            class: Image,
            config: {
                endpoints: {
                    byFile: uploadUrl,
                },
                additionalRequestHeaders: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    )?.content,
                },
                field: "image",
                types: "image/jpeg,image/jpg,image/png,image/gif",
                captionPlaceholder: "Keterangan gambar",
                buttonText: "Pilih Gambar",
            },
        },
    },
    onReady: () => {
        console.log("Editor.js is ready!");
    },
});

function saveEvent() {
    editor
        .save()
        .then((outputData) => {
            const descriptionInput =
                document.getElementById("descriptionInput");
            const form = document.getElementById("eventForm");

            if (!descriptionInput || !form) {
                console.error("Elemen form tidak ditemukan!");
                return;
            }

            descriptionInput.value = JSON.stringify(outputData);
            console.log("Data siap kirim:", descriptionInput.value);

            form.submit();
        })
        .catch((error) => {
            console.error("EditorJS Error:", error);
            alert("Gagal mengambil data deskripsi");
        });
}

window.saveEvent = saveEvent;
