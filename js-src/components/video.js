import { PluginLazyVideo } from "../functions/PluginLazyVideo";

document.querySelectorAll(".video").forEach((container) => {
  const videoUrl = container.dataset.videoUrl;
  const isFile = container.dataset.isFile === "true";

  if (videoUrl) {
    new PluginLazyVideo(videoUrl, {
      container: container,
      isFile: isFile,
    });
  }
});
