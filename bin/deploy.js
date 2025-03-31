import gcloud from "@battis/partly-gcloudy";
import { Core } from "@battis/qui-cli.core";
import { Root } from "@battis/qui-cli.root";
import { Shell } from "@battis/qui-cli.shell";
import path from "node:path";

(async () => {
  Root.configure({ root: path.dirname(import.meta.dirname) });
  const {
    values: { force },
  } = await Core.init({
    flag: {
      force: {
        short: "f",
        default: false,
      },
    },
  });

  if (force || !process.env.PROJECT) {
    await gcloud.services.enable(gcloud.services.API.CloudLoggingAPI);
    await gcloud.services.enable(gcloud.services.API.CloudFirestoreAPI);
    await gcloud.services.enable(gcloud.services.API.CloudLoggingAPI);
    const [{ name: database }] = JSON.parse(
      Shell.exec(
        `gcloud firestore databases list --project=${project.projectId} --format=json --quiet`
      )
    );
    Shell.exec(
      `gcloud firestore databases update --type=firestore-native --database="${database}" --project=${project.projectId} --format=json --quiet`
    );
  }

  const { project } = await gcloud.batch.appEngineDeployAndCleanup({
    retainVersions: 2,
  });
})();
