<h1>Videos List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Width</th>
      <th>Height</th>
      <th>Video bitrate</th>
      <th>Audio bitrate</th>
      <th>User</th>
      <th>Filename</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($videos as $video): ?>
    <tr>
      <td><a href="<?php echo url_for('@video_info?module=video&action=info&id='.$video->getId()) ?>"><?php echo $video->getId() ?></a></td>
      <td><?php echo $video->getName() ?></td>
      <td><?php echo $video->getWidth() ?></td>
      <td><?php echo $video->getHeight() ?></td>
      <td><?php echo $video->getVideoBitrate() ?></td>
      <td><?php echo $video->getAudioBitrate() ?></td>
      <td><?php echo $video->getUserId() ?></td>
      <td><?php echo $video->getFilename() ?></td>
      <td><?php echo $video->getCreatedAt() ?></td>
      <td><?php echo $video->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>